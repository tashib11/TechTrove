@extends('admin.layouts.app')

@section('content')

<div class="chart-container">
	<canvas id="pieChart"></canvas>
</div>

@endsection


@section('pie')


<script type="text/javascript">
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function() {
      $('.summernote').summernote({
        height: 200
      });
    });

    const ctx = document.getElementById('pieChart').getContext('2d');

    // Function to generate random colors
    function getRandomColor() {
      const letters = '0123456789ABCDEF';
      let color = '#';
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }

    let chartData = {
      labels: [],
      datasets: [{
        data: [],
        backgroundColor: []
      }]
    };

    @foreach($chartData as $item)
      chartData.labels.push('{{ $item->categoryName }} - {{ $item->brandName }}');
      chartData.datasets[0].data.push({{ $item->product_count }});
      chartData.datasets[0].backgroundColor.push(getRandomColor());
    @endforeach

    new Chart(ctx, {
      type: 'pie',
      data: chartData,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              fontSize: 20,
            }
          },
          title: {
            display: true,
            text: 'Most Sold Products by Category and Brand',
            font: {
              size: 30,
            }
          }
        }
      },
    });
  </script>

@endsection
