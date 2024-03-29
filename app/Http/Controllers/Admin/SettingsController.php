<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Settings\ThemeSettings;
use App\Settings\CompanySettings;
use App\Settings\InvoiceSettings;
use App\Http\Controllers\Controller;
use App\Settings\AttendanceSettings;

class SettingsController extends Controller
{

    public function index(ThemeSettings $settings)
    {
        $title = 'theme settings';
        return view('backend.settings.theme', compact(
            'title',
            'settings'
        ));
    }

    public function updateTheme(Request $request, ThemeSettings $settings)
    {
        $this->validate($request, [
            'site_name' => 'required',
            'logo' => 'nullable|file|image',
            'favicon' => 'nullable|file|image',
            'currency_symbol' => 'nullable|min:1|max:10',
            'currency_code' => 'nullable|min:1|max:10'
        ]);
        $logo = '';
        if ($request->hasFile('logo')) {
            $logo = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('storage/settings/theme'), $logo);
            $settings->logo = $logo;
        }
        $favicon = '';
        if ($request->hasFile('favicon')) {
            $favicon = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('storage/settings/theme'), $favicon);
            $settings->favicon = $favicon;
        }
        $settings->site_name = $request->site_name;
        $settings->currency_code = !empty($request->currency_code) ? $request->currency_code : '';
        $settings->currency_symbol = !empty($request->currency_symbol) ? $request->currency_symbol : '';
        $settings->theme_color = $request->theme_color;
        $settings->save();
        // $notification = notify('theme has been updated.');
        // return back()->with($notification);
        return back()->with('success', 'theme has been updated.');
    }

    public function invoice(InvoiceSettings $settings)
    {
        $title = 'invoice settings';
        return view('backend.settings.invoice', compact(
            'title',
            'settings'
        ));
    }

    public function updateInvoice(Request $request, InvoiceSettings $settings)
    {
        $this->validate($request, [
            'prefix' => 'nullable',
            'logo' => 'nullable|file|image'
        ]);
        $logo = $request->logo;
        if ($request->hasFile('logo')) {
            $logo = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('storage/settings/invoice'), $logo);
        }
        $settings->prefix = $request->prefix;
        $settings->logo = $logo;
        $settings->save();
        // $notification = notify('invoice settings updated');
        // return back()->with($notification);
        return back()->with('success', 'invoice settings updated.');
    }

    public function attendance(AttendanceSettings $settings)
    {
        $title = 'attendance settings';
        return view('backend.settings.attendance', compact(
            'title',
            'settings'
        ));
    }

    public function updateAttendance(Request $request, AttendanceSettings $settings)
    {
        $this->validate($request, [
            'checkin' => 'required',
            'checkout' => 'required'
        ]);
        $settings->checkin_time = $request->checkin;
        $settings->checkout_time = $request->checkout;
        $settings->save();
        $notification = notify('attendance settings updated');
        return back()->with($notification);
    }

    public function company(CompanySettings $settings)
    {
        $title = 'Company Information';
        return view('backend.settings.company', compact(
            'title',
            'settings'
        ));
    }

    public function updateCompany(Request $request, CompanySettings $settings)
    {
        $this->validate($request, [
            // 'company_name' => 'required',
            // 'contact_person' => 'required',
            // 'address' => 'required',
            // 'country' => 'required',
            // 'city' => 'required',
            // 'province' => 'required',
            // 'postal_code' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            // 'mobile' => 'required',
            // 'fax' => 'required',
            // 'website_url' => 'required|url',
            // 'timesheet_interval' => 'required',
        ]);

        $settings->company_name = !empty($request->company_name) ? $request->company_name : '';
        $settings->contact_person = !empty($request->contact_person) ? $request->contact_person : '';
        $settings->address = !empty($request->address) ? $request->address : '';
        $settings->country = !empty($request->country) ? $request->country : '';
        $settings->city = !empty($request->city) ? $request->city : '';
        $settings->province = !empty($request->province) ? $request->province : '';
        $settings->postal_code = !empty($request->postal_code) ? $request->province : '';
        $settings->email = !empty($request->email) ? $request->email : '';
        $settings->phone = !empty($request->phone) ? $request->phone : '';
        $settings->mobile = !empty($request->mobile) ? $request->mobile : '';
        $settings->fax = !empty($request->fax) ? $request->fax : '';
        $settings->website_url = !empty($request->website_url) ? $request->website_url : '';
        $settings->timesheet_interval = !empty($request->timesheet_interval) ? $request->timesheet_interval : '';
        $settings->save();
        // $notification = notify('Company settings has been updated.');
        // return back()->with($notification);

        return back()->with('success', 'Company settings has been updated.');
    }
}
