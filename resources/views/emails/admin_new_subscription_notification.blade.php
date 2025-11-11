<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Subscription Notification</title>
</head>
<body>
    <h2>New Store Subscription Pending</h2>
    <p>A new store has subscribed and requires admin review.</p>

    <ul>
        <li><strong>Store ID:</strong> {{ $store->id }}</li>
        <li><strong>Store Name:</strong> {{ $store->store_name }}</li>
        {{-- <li><strong>Status:</strong> {{ ucfirst($subscription->status) }}</li> --}}
    </ul>

    {{-- <p>Payment Receipt:</p>
    @if($subscription->payment_receipt_image)
        <a href="{{ asset('storage/' . $subscription->payment_receipt_image) }}" target="_blank">
            View Payment Receipt
        </a>
    @else
        <em>No image uploaded.</em>
    @endif --}}

    <br><br>
    <p>Login to the admin panel to review and approve or reject the subscription.</p>
</body>
</html>