<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {{-- <title>New Subscription Notification</title> --}}
    <title>إشعار بوجود اشتراك جديد</title>
</head>
<body>
    {{-- <h2>New Store Subscription Pending</h2> --}}
    {{-- <p>A new store has subscribed and requires admin review.</p> --}}
    <h2>اشتراك المتجر الجديد معلق</h2>
    <p>لقد تم الاشتراك في متجر جديد ويتطلب مراجعة المسؤول.</p>

    <ul>
        <li><strong>رقم المتجر:</strong> {{ $store->id }}</li>
        <li><strong>اسم المتجر:</strong> {{ $store->store_name }}</li>
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
    {{-- <p>Login to the admin panel to review and approve or reject the subscription.</p> --}}
    <p>قم بتسجيل الدخول إلى لوحة الإدارة لمراجعة الاشتراك والموافقة عليه أو رفضه.</p>
</body>
</html>
