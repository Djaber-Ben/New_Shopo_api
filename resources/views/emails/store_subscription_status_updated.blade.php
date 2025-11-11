<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Store Subscription Update Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Hello {{ $vendor->name }},</h2>

    <p>Your store subscription has been updated by the administrator. Here are the details:</p>

    <ul>
        <li><strong>Store ID:</strong> {{ $store->id }}</li>
        <li><strong>Store Name:</strong> {{ $store->name }}</li>
        <li><strong>Store Status:</strong> {{ ucfirst($store->status) }}</li>
        <li><strong>Subscription ID:</strong> {{ $subscription->id }}</li>
        <li><strong>Subscription Plan:</strong> {{ $subscription->subscriptionPlan->name ?? 'N/A' }}</li>
        <li><strong>Subscription Status:</strong> {{ ucfirst($subscription->status) }}</li>
        <li><strong>Start Date:</strong> {{ $subscription->start_date ?? 'N/A' }}</li>
        <li><strong>End Date:</strong> {{ $subscription->end_date ?? 'N/A' }}</li>
    </ul>

    <p>If you have any questions, please contact support.</p>

    <p>Best regards,<br>
    <strong>SHOPO Team</strong></p>
</body>
</html>