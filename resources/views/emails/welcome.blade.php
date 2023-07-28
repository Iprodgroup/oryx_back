<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Message</title>

</head>
<body class="body">
<p>
    Telefon: {{ $purchase['nomer'] }} <br />

    @foreach($purchase['products'] as $product)
        LINK: {{ $product['product-link'] }}<br />
        INFO: {{ $product['product-info'] }}<br />
        NAME: {{ $product['product-name'] }}<br /><br />
    @endforeach

</p>
</body>
</html>
