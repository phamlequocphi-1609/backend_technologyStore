<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $details['subject'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .subject {
            color: #af0313;
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin-bottom: 10px;
        }
        .cart {
            margin-top: 20px;
        }
        .cart ul {
            list-style-type: none;
            padding: 0;
        }
        .cart li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            margin-left: 0px;
        }
        .cart li:last-child {
            border-bottom: none;
        }
        .question{
            font-size: 15px;
            font-weight: bold;
            margin: 0px;
        }
        .thank{
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="subject">{{ $details['subject'] }}</h1>
        <h3>Hello {{$details['body']['name']}}. Your order has been places successfully on {{$details['body']['orderdate']}}</h3>
        <div class="details">
            <p><strong>Name:</strong> {{ $details['body']['name'] }}</p>
            <p><strong>Company:</strong> {{ $details['body']['company'] }}</p>
            <p><strong>Country:</strong> {{ $details['body']['country'] }}</p>
            <p><strong>Address:</strong> {{ $details['body']['address'] }}</p>
            <p><strong>Province/City:</strong> {{ $details['body']['provincecity'] }}</p>
            <p><strong>Phone:</strong> {{ $details['body']['phone'] }}</p>
            <p><strong>Order Code:</strong> {{ $details['body']['ordercode'] }}</p>
            <p><strong>Note:</strong> {{ $details['body']['note'] }}</p>
        </div>
        <h2 class="subject">Cart Details</h2>
        <div class="cart">
            <ul>
                @foreach ($details['body']['cart'] as $item)
                    <li>
                        <p><strong>Product Name:</strong> {{ $item['name'] }}</p>
                        <p><strong>Price:</strong> {{ number_format($item['price'], 0, ',', '.') }} VND</p>            
                        <p><strong>Quantity:</strong> {{ $item['qty'] }}</p>
                    </li>
                @endforeach
                <li>
                    <p><strong>Shipping Cost:</strong> Free</p>
                </li>
                <li>
                    <p><strong>Tax:</strong> 20.000 VND</p>
                </li>
                <li>
                    <p><strong>Total:</strong> {{number_format($details['body']['total'] + 20000)}} VND</p>
                </li>
            </ul>
        </div>
        <p class="question">If you have any question concerning this invoice, contact me</p>
        <p class="question">Phone number : 0385841468</p>
        <p class="question">Email address: philipbiran@gmail.com</p>
        <p class="thank">Thank you</p>
    </div>
</body>
</html>
