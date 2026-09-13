<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\User;
use Spatie\Permission\Models\Role;

class NotificationSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = NotificationSetting::with(['user', 'role'])->latest();

        if ($request->filled('notification_type')) {
            $query->where('notification_type', $request->notification_type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $settings = $query->paginate(15)->withQueryString();

        $notificationTypes = $this->notificationTypes();

        return view('admin.notification_settings.index', compact('settings', 'notificationTypes'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $notificationTypes = $this->notificationTypes();

        return view('admin.notification_settings.create', compact('users', 'roles', 'notificationTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'notification_type' => 'required|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'role_id'           => 'nullable|exists:roles,id',
            'mail_enabled'      => 'nullable|boolean',
            'system_enabled'    => 'nullable|boolean',
            'sms_enabled'       => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
        ]);

        if (empty($data['user_id']) && empty($data['role_id'])) {
            return back()->withInput()->with('error_message', 'Please select at least one User or Role.');
        }

        $exists = NotificationSetting::where('notification_type', $data['notification_type'])
            ->where('user_id', $data['user_id'] ?? null)
            ->where('role_id', $data['role_id'] ?? null)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error_message', 'This notification setting already exists.');
        }

        $data['mail_enabled'] = $request->boolean('mail_enabled');
        $data['system_enabled'] = $request->boolean('system_enabled');
        $data['sms_enabled'] = $request->boolean('sms_enabled');
        $data['is_active'] = $request->boolean('is_active');

        NotificationSetting::create($data);

        return redirect()->route('admin.notification-settings.index')
            ->with('success_message', 'Notification setting created successfully.');
    }

    public function edit($id)
    {
        $setting = NotificationSetting::findOrFail($id);
        $users = User::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $notificationTypes = $this->notificationTypes();

        return view('admin.notification_settings.edit', compact('setting', 'users', 'roles', 'notificationTypes'));
    }

    public function update(Request $request, $id)
    {
        $setting = NotificationSetting::findOrFail($id);

        $data = $request->validate([
            'notification_type' => 'required|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'role_id'           => 'nullable|exists:roles,id',
            'mail_enabled'      => 'nullable|boolean',
            'system_enabled'    => 'nullable|boolean',
            'sms_enabled'       => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
        ]);

        if (empty($data['user_id']) && empty($data['role_id'])) {
            return back()->withInput()->with('error_message', 'Please select at least one User or Role.');
        }

        $exists = NotificationSetting::where('notification_type', $data['notification_type'])
            ->where('user_id', $data['user_id'] ?? null)
            ->where('role_id', $data['role_id'] ?? null)
            ->where('id', '!=', $setting->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error_message', 'This notification setting already exists.');
        }

        $data['mail_enabled'] = $request->boolean('mail_enabled');
        $data['system_enabled'] = $request->boolean('system_enabled');
        $data['sms_enabled'] = $request->boolean('sms_enabled');
        $data['is_active'] = $request->boolean('is_active');

        $setting->update($data);

        return redirect()->route('admin.notification-settings.index')
            ->with('success_message', 'Notification setting updated successfully.');
    }

    public function destroy($id)
    {
        $setting = NotificationSetting::findOrFail($id);
        $setting->delete();

        return redirect()->route('admin.notification-settings.index')
            ->with('success_message', 'Notification setting deleted successfully.');
    }

    private function notificationTypes(): array
    {
        return [
            'payment_received' => 'Payment Received',
            // 'payment_sent' => 'Payment Sent',
            'proforma_created' => 'Proforma Created',
            'invoice_created' => 'Invoice Created',
            // 'warranty_created' => 'Warranty Created',
            // 'warranty_claim_created' => 'Warranty Claim Created',
            // 'warranty_claim_updated' => 'Warranty Claim Updated',
            // 'otp_generated' => 'OTP Generated',
            // 'lead_created' => 'Lead Created',
            // 'lead_updated' => 'Lead Updated',
            // 'service_created' => 'Service Created',
            // 'service_updated' => 'Service Updated',
            'convert_to_processing' => 'Performa Convert to Processing',
            'raw_material' => 'Raw Material Assigned',
            'manufacturing_started' => 'Manufacturing Started',
            'status_update' => 'Status Update',
            'send_to_delivery' => 'Send to delivery',
            'order_dispacth' => 'Order Dispatch',
            'support' => 'Support Request',
            'warranty_claim' => 'Warranty Claim',
            'salary_ready' => 'Salary'
        ];
    }
}
