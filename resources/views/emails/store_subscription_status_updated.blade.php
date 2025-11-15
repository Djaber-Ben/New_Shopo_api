<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {{-- <title>Store Subscription Update Notification</title> --}}
    <title>إشعار بتحديث اشتراك المتجر</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>مرحبًا {{ $vendor->name }},</h2>

    {{-- <p>Your store subscription has been updated by the administrator. Here are the details:</p> --}}
    <p>قام المسؤول بتحديث اشتراكك في المتجر. إليك التفاصيل:</p>

    <ul>
        <li><strong>رقم المتجر:</strong> {{ $store->id }}</li>
        <li><strong>اسم المتجر:</strong> {{ $store->store_name }}</li>
        <li><strong>حالة المتجر:</strong> {{ ucfirst($store->status) }}</li>
        <li><strong>رقم الاشتراك:</strong> {{ $subscription->id }}</li>
        <li><strong>اسم خطة الاشتراك:</strong> {{ $subscription->subscriptionPlan->name ?? 'N/A' }}</li>
        <li><strong>حالة خطة الاشتراك:</strong> {{ ucfirst($subscription->status) }}</li>
        <li><strong>تاريخ البداية:</strong> {{ $subscription->start_date ?? 'N/A' }}</li>
        <li><strong>تاريخ النهاية:</strong> {{ $subscription->end_date ?? 'N/A' }}</li>
    </ul>

    {{-- <p>If you have any questions, please contact support.</p> --}}
    <p>إذا كان لديك أي أسئلة، يرجى الاتصال بالدعم.</p>

    <p>أطيب التحيات،<br>
    <strong>SHOPO فريق</strong></p>
</body>
</html>
