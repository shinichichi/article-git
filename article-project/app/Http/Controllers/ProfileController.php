<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use App\Models\User;


class ProfileController extends Controller
{
    /**
     * プロフィール変更ページへ
     */
    public function edit(Request $request): View
    {
        $user = User::where('id', Auth::user()->id)->first();
        // $icon = User::findOrFail(Auth::user());

        // if ($user->icon != null) {
        //     $icon = $user->data;
        // }
 
        return view('profile.edit', [
            'user' => $user,
            // 'icon' => $icon,
        ]);
    }

    /**
     * アイコン変更更新
     */
    public function iconchange(Request $request): View
    {
        // アップロードされたファイル
        $file = $request->file('icon_image_path');
        $fileName = $file->getClientOriginalName();
        $fileData = file_get_contents($file);

        // 画像をデータベースに保存
        DB::table('users')->where('id', Auth::user()->id)->update([
            'icon' => $fileName,
            'data' => $fileData,
        ]);

        $user = User::where('id', Auth::user()->id)->first();

        return view('profile.edit', [
            'user' => $user,
            // 'icon' => $icon,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
    * アカウント削除用アンケート入力画面へ
    */
    public function delete_questionnaire(Request $request): View
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        return view('profile.questionnaire_conf', compact('user'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $user = $request->user();
        $why_quit = $request['why_quit'];
        $quit_comment = $request['quit_comment'];

        DB::table('users')->where('id', $user->id)->update(['is_delete' => now()]);
        DB::table('users')->where('id', $user->id)->update(['why_quit' => $why_quit]);
        DB::table('users')->where('id', $user->id)->update(['quit_comment' => $quit_comment]);
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/quit');
    }

    /**
     * 公開プロフィール編集画面へ
     */
    public function open_profile(Request $request): View
    {
        return view('profile.open_profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * 公開プロフィール編集変更
     */
    public function open_profile_store(Request $request)
    {
        $request->validate([
            'user_name' => ['required',  'max:255'],
            'account_name' => ['required', 'max:255'],
        ]);

        $user = $request->user();
        $user_name = $request['user_name'];
        $account_name = $request['account_name'];
        $open_email = $request['open_email'];
        $site_url = $request['site_url'];
        $self_introduction = $request['self_introduction'];

        DB::table('users')->where('id', $user->id)->update(['user_name' => $user_name]);
        DB::table('users')->where('id', $user->id)->update(['account_name' => $account_name]);
        DB::table('users')->where('id', $user->id)->update(['open_email' => $open_email]);
        DB::table('users')->where('id', $user->id)->update(['site_url' => $site_url]);
        DB::table('users')->where('id', $user->id)->update(['self_introduction' => $self_introduction]);

        session()->flash('message', '変更が完了しました。');

        return redirect()->route('open_profile')->with('user', $user);
    }

    /**
     * お問い合わせ確認
     */
    public function forminputconf(Request $request): View
    {
        $item = $request;
        return view('form_input_conf')->with('item', $item);
    }

    /**
     * お問い合わせ完了、問い合わせを運営のメールに送る
     */
    public function forminputcomp(Request $request):RedirectResponse
    {
        $data = $request;
        Mail::to('example@gamil.com')->send(new Sendmail($data));
        // return view('form_input')->with('message','お知らせの変更が完了しました。');
        return redirect()->route('forminputcompshow')->with('user',);
    }

    /**
     * お問い合わせ完了、問い合わせを運営のメールに送る
     */
    public function forminputcompshow(Request $request):View
    {
        $data = $request;
        return view('form_input_comp_show')->with('data', $data);
        }
}
