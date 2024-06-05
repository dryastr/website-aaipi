<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class BaseLayout extends Component
{
    public $scrollspy;

    public $title;

    public $isAuth = false;

    public $user = null;

    public $notification_keanggotaan;

    /**
     * Create a new component instance.
     */
    public function __construct($scrollspy = false, $title = '')
    {
        $this->scrollspy = $scrollspy;
        $this->title = $title;

        if (Auth::check()) {
            $model = new User();
            $this->user = $model->getMe()->toArray();
            $this->isAuth = true;
            $this->notification_keanggotaan = $model->status_keanggotaan($this->user['id']);

            if (! Route::is('profile.index') && $this->user['role_id'] == 3) {
                $user = $this->user['registration'];
                if ($user['nama_instansi'] == null && $user['jabatan'] == null && $user['alamat'] == null) {
                    echo '<script>window.location.href="'.route('profile.index').'"</script>';
                }
            }

            if (! $this->user['is_admin']) {
                abort(404);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin.layouts.master');
    }
}
