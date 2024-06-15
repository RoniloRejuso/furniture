<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Occurrence Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="productChart" width="300" height="300"></canvas>

    <script>
        const orders = [
            { product_name: 'Our Home Sofa , Hallie Bar Set ' },
            { product_name: 'Our Home Sofa , Portland Bar Set ' },
            { product_name: 'Our Home Sofa , Aubrey Bedframe ' },
            { product_name: 'Our Home Sofa , Christan Sectional Sofa ' },
            { product_name: 'Our Home cullen sectional sofa , Copenhagen Sectional ' },
            { product_name: 'Copenhagen Sectional , Aubrey Bedframe ' },
            { product_name: 'Aubrey Bedframe , Portland Bar Set ' },
            { product_name: 'Christan Sectional Sofa , Gervaise Bedframe ' },
            { product_name: 'Our Home cardiff sleeper sofa , Copenhagen Sectional ' },
            { product_name: 'Our Home conakry 2 seater sofa , Copenhagen Sectional ' },

        ];

        // Count occurrences of each product name
        const productCount = {};
        orders.forEach(order => {
            const products = order.product_name.split(', ');
            products.forEach(product => {
                productCount[product] = (productCount[product] || 0) + 1;
            });
        });

        // Extract product names and counts for chart data
        const productNames = Object.keys(productCount);
        const productCounts = Object.values(productCount);

        // Generate random colors for each bar
        const colors = productNames.map(() => {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgb(${r}, ${g}, ${b})`;
        });

        // Create the bar chart
        const ctx = document.getElementById('productChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Product Occurrence',
                    data: productCounts,
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
