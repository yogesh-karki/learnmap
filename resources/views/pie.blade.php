<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
    <title>Doughnut Chart Using Chart JS</title>
</head>

<body>
    <label for="project">Choose a project:</label>
    <select name="project" id="project" class="project">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    @foreach ($categories as $item)
        <canvas class="canvas" id="pie-chart{{ $item->id }}" height="50" width="150"></canvas>
    @endforeach
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="{{ asset('chartjs-plugin-doughnutlabel.js') }}"></script>
<script type="text/javascript">

</script>

<script>
    $(document).ready(function() {
        callMethod(1);
        $('.project').change(function() {
            var value = $(this).val();
            callMethod(value);

        });
    });

    function callMethod(value) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('dynamic') }}",
            type: "POST",
            data: {
                value: value
            },
            beforeSend: function() {},
            success: function(response) {
                $('.canvas').hide();
                $('#pie-chart' + response.id).show();
                var data = [{
                    data: response.quantity,
                    backgroundColor: response.color,
                    hoverBackgroundColor: response.color,
                }];

                var options = {
                    responsive: true,
                    legend: {
                        onClick: (e) => e.stopPropagation(),
                        display: true,
                    },
                    tooltips: {
                        enabled: true
                    },
                    plugins: {
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = response.sum;
                                let percentage = (value * 100 / sum).toFixed(2) + "%";
                                return percentage;
                            },
                            color: '#fff',
                        },
                        doughnutlabel: {
                            labels: [{
                                text: response.sum,
                                font: {
                                    size: 20,
                                    weight: 'bold'
                                }
                            }, {
                                text: 'total'
                            }]
                        }
                    }
                };

                var ctx = document.getElementById("pie-chart" + response.id).getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: response.chartData,
                        datasets: data
                    },
                    options: options
                });
            }
        });
    }
</script>

</html>
