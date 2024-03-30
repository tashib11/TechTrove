<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Helper\SSLCommerz;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\Log;

class InvoiceController extends Controller
{

    function InvoiceCreate(Request $request): JsonResponse
    {

        DB::beginTransaction();
        try{

            $user_id=$request->header('id');
            $user_email=$request->header('email');

            $tran_id=uniqid();
            $delivery_status='Pending';
            $payment_status='Pending';

            $Profile=CustomerProfile::where('user_id','=',$user_id)->first();

            $cus_details="Name: $Profile->cus_name, Address: $Profile->cus_add, City:$Profile->cus_city,  Phone: $Profile->cus_phone";
            $ship_details="Name: $Profile->ship_name, Address: $Profile->ship_add, City:$Profile->ship_city,  Phone: $Profile->ship_phone";

            //Payable calculation

            $total=0;

            $cartList=ProductCart::where('user_id','=',$user_id)->get();
            foreach ($cartList as $cart){
              $total+=$cart->price;
            }

            $vat=($total*5)/100;
            $payable=$total+$vat;

            $invoice=Invoice::create([
                'total'=>$total,
                'vat'=>$vat,
                'payable'=>$payable,
                'cus_details'=>$cus_details,
                'ship_details'=>$ship_details,
                'tran_id'=>$tran_id,

                'delivery_status'=>$delivery_status,
                'payment_status'=>$payment_status,
                'user_id'=>$user_id,
            ]);

            $invoiceID=$invoice->id;
try{
            foreach($cartList as $cart){
                InvoiceProduct::create([

                    'qty'=>$cart['qty'],
                    'sale_price'=>$cart['price'],
                    'invoice_id'=>$invoiceID,
                    'product_id'=>$cart['product_id'],
                  'user_id'=>$user_id,

                ]);
            }
        }
        catch (Exception $e){
            return ResponseHelper::Out('InvoiceProduct failed',$e,200);

        }
            $paymentMethod=SSLCommerz::initiatePayment($Profile,$payable,$tran_id,$user_email);
            DB::commit();

return ResponseHelper::Out('Invoice Created Successfully',array(['paymentMethod'=>$paymentMethod,'payable'=>$payable,'vat'=>$vat,'total'=>$total]),200);
        }
        catch (Exception $e){
            DB::rollBack();
            return ResponseHelper::Out('Invoice Creation Failed',$e,200);
        }

    }


    function InvoiceList(Request $request)
    {
        $user_id=$request->header('id');
        return Invoice::where('user_id',$user_id)->get();
    }

    function InvoiceProductList(Request $request)
    {
        $user_id=$request->header('id');
        $invoice_id=$request->invoice_id;
        return InvoiceProduct::where(['user_id'=>$user_id,'invoice_id'=>$invoice_id])->with('product')->get();
    }

    function PaymentSuccess(Request $request)
    {
       return SSLCommerz::InitiateSuccess($request->query('tran_id'));
    }
    function PaymentCancel(Request $request)
    {
       return SSLCommerz::InitiateCancel($request->query('tran_id'));
    }
    function PaymentFail(Request $request)
    {
       return SSLCommerz::InitiateFail($request->query('tran_id'));
    }

    function PaymentIPN(Request $request)
    {
       return SSLCommerz::InitiateIPN($request->input('tran_id'),$request->input('status'),$request->input('val_id'));
    }
}
