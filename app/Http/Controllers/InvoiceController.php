<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Helper\SSLCommerz;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
          public function PaymentPage() {
            return view('pages.payment-page');
        }
      public function placeOrder(Request $request): JsonResponse
{
    $user_id = $request->header('id');

    // Validate essential fields
    $request->validate([
        'shipping_name' => 'required|string|max:255',
        'shipping_phone' => 'required|string|max:20',
        'shipping_city' => 'required|string|max:100',
        'shipping_division' => 'required|string|max:100',
        'shipping_address' => 'required|string',
        'payable' => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {
        // Determine shipping fee
        $city = strtolower(trim($request->shipping_city));
        $shippingFee = $city === 'dhaka' ? 60 : 150;

        // Calculate subtotal from cart
        $cartItems = ProductCart::where('user_id', $user_id)->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->qty;
        });

        // Calculate final total
        $giftWrapCost = ($request->gift_wrap ?? 0) == 1 ? 30 : 0;
        $finalTotal = $subtotal + $shippingFee + $giftWrapCost;

        // Create invoice
        $invoice = Invoice::create([
            'user_id' => $user_id,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_alt_phone' => $request->shipping_alt_phone ?? null,
            'shipping_city' => $request->shipping_city,
            'shipping_division' => $request->shipping_division,
            'shipping_address' => $request->shipping_address,
            'gift_wrap' => $request->gift_wrap ?? 0,
            'shipping_fee' => $shippingFee,
            'total' => $finalTotal,
            'tran_id' => 'TRX_' . uniqid(),
        ]);

        foreach ($cartItems as $item) {
            InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'user_id' => $user_id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'color' => $item->color,
                'size' => $item->size,
            ]);
        }

        ProductCart::where('user_id', $user_id)->delete();

        DB::commit();
        return ResponseHelper::Out('Order placed successfully', ['tran_id' => $invoice->tran_id], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return ResponseHelper::Out('fail', 'Order placement failed. ' . $e->getMessage(), 500);
    }
}
    // function InvoiceCreate(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {

    //         //
    //         $user_id=$request->header('id');
    //         $user_email=$request->header('email');

    //         $tran_id=uniqid();
    //         $delivery_status='Pending';
    //         $payment_status='Pending';

    //         $Profile=CustomerProfile::where('user_id','=',$user_id)->first();
    //         $cus_details="Name:$Profile->cus_name,Address:$Profile->cus_add,City:$Profile->cus_city,Phone: $Profile->cus_phone";
    //         $ship_details="Name:$Profile->ship_name,Address:$Profile->ship_add ,City:$Profile->ship_city ,Phone: $Profile->cus_phone";

    //         // Payable Calculation
    //         $total=0;
    //         $cartList=ProductCart::where('user_id','=',$user_id)->get();
    //         foreach ($cartList as $cartItem) {
    //             $total=$total+$cartItem->price;
    //         }

    //         $vat=($total*3)/100;
    //         $payable=$total+$vat;

    //         $invoice= Invoice::create([
    //             'total'=>$total,
    //             'vat'=>$vat,
    //             'payable'=>$payable,
    //             'cus_details'=>$cus_details,
    //             'ship_details'=>$ship_details,
    //             'tran_id'=>$tran_id,
    //             'delivery_status'=>$delivery_status,
    //             'payment_status'=>$payment_status,
    //             'user_id'=>$user_id
    //         ]);

    //         $invoiceID=$invoice->id;

    //         foreach ($cartList as $EachProduct) {
    //             InvoiceProduct::create([
    //                 'invoice_id' => $invoiceID,
    //                 'product_id' => $EachProduct['product_id'],
    //                 'user_id'=>$user_id,
    //                 'qty' =>  $EachProduct['qty'],
    //                 'sale_price'=>  $EachProduct['price'],
    //             ]);
    //         }

    //        $paymentMethod=SSLCommerz::InitiatePayment($Profile,$payable,$tran_id,$user_email);

    //        DB::commit();

    //        return ResponseHelper::Out('success',array(['paymentMethod'=>$paymentMethod,'payable'=>$payable,'vat'=>$vat,'total'=>$total]),200);

    //     }
    //     catch (Exception $e) {
    //         DB::rollBack();
    //         return ResponseHelper::Out('fail',$e,200);
    //     }

    // }

    // function InvoiceList(Request $request){
    //     $user_id=$request->header('id');
    //     return Invoice::where('user_id',$user_id)->get();
    // }

    // function InvoiceProductList(Request $request){
    //     $user_id=$request->header('id');
    //     $invoice_id=$request->invoice_id;
    //     return InvoiceProduct::where(['user_id'=>$user_id,'invoice_id'=>$invoice_id])->with('product')->get();
    // }

    // function PaymentSuccess(Request $request){
    //     SSLCommerz::InitiateSuccess($request->query('tran_id'));
    //     return redirect('/profile');
    // }


    // function PaymentCancel(Request $request){
    //     SSLCommerz::InitiateCancel($request->query('tran_id'));
    //     return redirect('/profile');
    // }

    // function PaymentFail(Request $request){
    //     SSLCommerz::InitiateFail($request->query('tran_id'));
    //     return redirect('/profile');
    // }

    // function PaymentIPN(Request $request){
    //     return SSLCommerz::InitiateIPN($request->input('tran_id'),$request->input('status'),$request->input('val_id'));
    // }



    public function index() {
        $data = [];
        $invs = Invoice::latest('id')->paginate();
    $data['invs'] = $invs;
        return view('admin.products.invoicelist', $data);
    }

    public function showPieChart()
    {
        $data = Invoice::query()
            ->join('invoice_products', 'invoices.id', '=', 'invoice_products.invoice_id')
            ->join('products', 'invoice_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                DB::raw("COUNT(invoice_products.product_id) as product_count"),
                'categories.categoryName',
                'brands.brandName'
            )
            ->where('invoices.payment_status', 'Success')
            ->groupBy('categories.categoryName', 'brands.brandName')
            ->get();

        return view('admin.products.piechart', ['chartData' => $data]);
    }



}
