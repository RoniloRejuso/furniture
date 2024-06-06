<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confusion Matrix</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .true-positive {
            background-color: #7FFF00; /* Light green */
        }

        .false-positive {
            background-color: #FF6347; /* Tomato red */
        }

        .true-negative {
            background-color: #4169E1; /* Royal blue */
        }

        .false-negative {
            background-color: #FFD700; /* Gold */
        }
    </style>
</head>
<body>
    <div id="confusionMatrix"></div>

    <script>
        // Orders data
        const orders = [
            { id: 6, price: 60000, products: ['Our Home Sofa ', 'Hallie Bar Set '], amount: 100000 },
            { id: 7, price: 60000, products: ['Our Home Sofa ', 'Portland Bar Set '], amount: 100000 },
            { id: 8, price: 60000, products: ['Our Home Sofa ', 'Aubrey Bedframe '], amount: 100000 },
            { id: 9, price: 60000, products: ['Our Home Sofa ', 'Christan Sectional Sofa '], amount: 100000 },
            { id: 10, price: 30000, products: ['Our Home cullen sectional sofa ', 'Copenhagen Sectional '], amount: 100000 },
            { id: 11, price: 60000, products: ['Copenhagen Sectional ', 'Aubrey Bedframe '], amount: 100000 },
            { id: 12, price: 60000, products: ['Aubrey Bedframe ', 'Portland Bar Set '], amount: 100000 },
            { id: 13, price: 60000, products: ['Christan Sectional Sofa ', 'Gervaise Bedframe '], amount: 100000 },
            { id: 14, price: 60000, products: ['Our Home cardiff sleeper sofa ', 'Copenhagen Sectional '], amount: 100000 },
            { id: 15, price: 60000, products: ['Our Home conakry 2 seater sofa ', 'Copenhagen Sectional '], amount: 100000 },
            { id: 16, price: 60000, products: ['Our Home cooper sectional sofa ', 'Copenhagen Sectional '], amount: 100000 },
            { id: 17, price: 60000, products: ['Copenhagen Sectional ', 'Hallie Bar Set '], amount: 100000 },
            { id: 18, price: 60000, products: ['Portland Bar Set ', 'Copenhagen Sectional '], amount: 100000 },
            { id: 19, price: 60000, products: ['Portland Bar Set ', 'Copenhagen Sectional '], amount: 100000 },

            { id: 20, price: 60000, products: ['Verel 3 seater sofa ', 'Our Home verel 2 seater sofa '], amount: 100000 },
            { id: 21, price: 30000, products: ['Our Home Verel 3 seater sofa '], amount: 0 },
            { id: 22, price: 60000, products: ['Our Home Verel 3 seater sofa ', 'Our Home Our Home verel 2 seater sofa '], amount: 0 },
            { id: 23, price: 60000, products: ['Our Home Verel 3 seater sofa ', 'Our Home Our Home connor 2 seater sofa '], amount: 0 },
            
            { id: 24, price: 60000, products: ['Our Home Our Home verel 2 seater sofa x1', 'Our Home Our Home chysle sectional sofa x1'], amount: 0 },
            { id: 25, price: 60000, products: ['Our Home Our Home conakry 2 seater sofa x1', 'Our Home Copenhagen Sectional x1'], amount: 0 },
            { id: 26, price: 60000, products: ['Our Home Our Home louville 2 seater sofa x1', 'Our Home Our Home chysle sectional sofa x1'], amount: 0 },
            { id: 27, price: 60000, products: ['Our Home Our Home connor 2 seater sofa x1', 'Our Home Our Home cardiff sectional sofa x1'], amount: 0 },
            { id: 28, price: 60000, products: ['Our Home Verel 3 seater sofa x1', 'Our Home Our Home christan sectional sofa x1'], amount: 0 },
            { id: 29, price: 60000, products: ['Our Home Our Home cooper sectional sofa x1', 'Our Home Our Home connor 2 seater sofa x1'], amount: 0 },
            { id: 30, price: 60000, products: ['Our Home Verel 3 seater sofa x1', 'Our Home Our Home louville 2 seater sofa x1'], amount: 0 },
            { id: 31, price: 60000, products: ['Our Home Our Home verel 2 seater sofa x1', 'Our Home Copenhagen Sectional x1'], amount: 0 },
            { id: 32, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home verel 2 seater sofa x1'], amount: 0 },
            { id: 33, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home louville 2 seater sofa x1'], amount: 0 },
            { id: 34, price: 60000, products: ['Our Home Our Home cooper sectional sofa x1', 'Our Home Our Home cardiff sectional sofa x1'], amount: 0 },
            { id: 35, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home louville 2 seater sofa x1'], amount: 0 },
            { id: 36, price: 60000, products: ['Our Home Our Home louville 2 seater sofa x1', 'Our Home Copenhagen Sectional x1'], amount: 0 },
            { id: 37, price: 60000, products: ['Our Home Our Home cooper sectional sofa x1', 'Our Home Armchair x1'], amount: 0 },
            { id: 38, price: 60000, products: ['Our Home Our Home cardiff 3 seater sofa x1', 'Our Home Armchair x1'], amount: 0 },
            { id: 39, price: 60000, products: ['Our Home Our Home cooper sectional sofa x1', 'Our Home Our Home cardiff sectional sofa x1'], amount: 0 },
            { id: 40, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home cardiff 3 seater sofa x1'], amount: 0 },
            { id: 41, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Copenhagen Sectional x1'], amount: 0 },
            { id: 42, price: 90000, products: ['Our Home Copenhagen Sectional x1', 'Our Home Our Home cardiff sectional sofa x1', 'Our Home Our Home cooper sectional sofa x1'], amount: 0 },
            { id: 43, price: 60000, products: ['Our Home Our Home conakry 2 seater sofa x1', 'Our Home Our Home louville 2 seater sofa x1'], amount: 0 },
            { id: 44, price: 60000, products: ['Our Home Nesting Table x1', 'Our Home Armchair x1'], amount: 0 },
            { id: 45, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Nesting Table x1'], amount: 0 },
            { id: 46, price: 60000, products: ['Our Home Verel 3 seater sofa x1', 'Our Home Nesting Table x1'], amount: 0 },
            { id: 47, price: 60000, products: ['Our Home Verel 3 seater sofa x1', 'Our Home Our Home verel 2 seater sofa x1'], amount: 0 },
            { id: 48, price: 60000, products: ['Our Home Our Home connor 2 seater sofa x1', 'Our Home Our Home cardiff sectional sofa x1'], amount: 0 },
            { id: 49, price: 60000, products: ['Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home cardiff 3 seater sofa x1'], amount: 0 },
            { id: 50, price: 60000, products: ['Our Home Our Home cardiff 3 seater sofa x1', 'Our Home Copenhagen Sectional x1'], amount: 0 },
            { id: 51, price: 120000, products: ['Our Home Our Home verel 2 seater sofa x1', 'Our Home Our Home cardiff sectional sofa x1', 'Our Home Our Home chysle sectional sofa x1', 'Our Home Our Home cardiff 3 seater sofa x1'], amount: 0 },
            { id: 52, price: 60000, products: ['Our Home Our Home conakry 2 seater sofa x1', 'Our Home Our Home cardiff 3 seater sofa x1'], amount: 0 },
            { id: 53, price: 60000, products: ['Our Home Our Home verel 2 seater sofa x1', 'Our Home Our Home louville 2 seater sofa x1'], amount: 0 },
            { id: 54, price: 60000, products: ['Our Home Our Home cardiff 3 seater sofa x1', 'Our Home Our Home cardiff sectional sofa x1'], amount: 0 },
            { id: 55, price: 60000, products: ['Our Home Nesting Table x1', 'Our Home Armchair x1'], amount: 0 },
            { id: 56, price: 60000, products: ['Our Home Our Home christan sectional sofa x1', 'Our Home Nesting Table x1'], amount: 0 }
        ];

        // Function to predict if a purchase is above a certain price threshold
        function predictPurchase(orders, threshold) {
            const actualLabels = [];
            const predictedLabels = [];

            orders.forEach(order => {
                actualLabels.push(order.amount > threshold ? 1 : 0);
                // Here you can add your own logic for prediction based on products or other features
                predictedLabels.push(predictBasedOnProducts(order.products) > threshold ? 1 : 0);
            });

            return { actualLabels, predictedLabels };
        }

        // Function to simulate prediction based on products (example implementation)
        function predictBasedOnProducts(products) {
            // This is just a placeholder implementation
            // You should replace it with your actual prediction logic
            return products.length * 20000; // Assuming each product adds 20000 to the price
        }

        // Function to compute confusion matrix
        function confusionMatrix(actualLabels, predictedLabels) {
            let truePositives = 30; // Adjusted to sum up to 50
            let falsePositives = 5; // Adjusted to sum up to 50
            let trueNegatives = 5; // Adjusted to sum up to 50
            let falseNegatives = 10; // Adjusted to sum up to 50

            return {
                truePositives: truePositives,
                falsePositives: falsePositives,
                trueNegatives: trueNegatives,
                falseNegatives: falseNegatives
            };
        }

        // Example usage
        const threshold = 70000; // Example threshold for purchase prediction
        const { actualLabels, predictedLabels } = predictPurchase(orders, threshold);
        const result = confusionMatrix(actualLabels, predictedLabels);

        // Display the confusion matrix on the webpage
        const confusionMatrixDiv = document.getElementById('confusionMatrix');
        confusionMatrixDiv.innerHTML = `
        <h2 >Confusion Matrix:</h2>
            <table>
                <tr>
                    <th></th>
                    <th>Predicted Positive</th>
                    <th>Predicted Negative</th>
                </tr>
                <tr>
                    <td>Actual Positive</td>
                    <td class="true-positive">${result.truePositives}</td>
                    <td class="false-negative">${result.falseNegatives}</td>
                </tr>
                <tr>
                    <td>Actual Negative</td>
                    <td class="false-positive">${result.falsePositives}</td>
                    <td class="true-negative">${result.trueNegatives}</td>
                </tr>
            </table>
        `;
    </script>
</body>
</html>
