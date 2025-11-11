<?php

namespace App\Http\Controllers;

use App\Models\SiteInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
  public function index()
  {
    $siteInfos = SiteInfo::all();
    return view('admin.siteInfos.index', compact('siteInfos'));
  }

  public function edit($key)
  {
    $siteInfo = SiteInfo::firstOrCreate(['key' => $key]);
    return view('admin.siteInfos.edit', compact('siteInfo'));
  }

  public function update(Request $request, $key)
  {
    $request->validate([
      'content' => 'required',
    ]);

    $siteInfo = SiteInfo::where('key', $key)->firstOrFail();

    // ✅ Clean HTML but allow certain tags
    $cleanHtml = strip_tags($request->content, '<li><i><p><b><strong><em><br><a>');

    $siteInfo->update([
      'content' => $cleanHtml
    ]);

    return redirect()
      ->route('siteInfos.index')
      ->with('success', ucfirst($key) . ' تم التحديث بنجاح!');
  }

  // Convenience shortcuts
  public function contact()
  {
    return $this->edit('contact');
  }
  public function about()
  {
    return $this->edit('about');
  }
  // public function faq() { return $this->edit('faq'); }
}