<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

trait AssertsViews
{
    use SetsViewVariables;

    public function assertViewRenders(
        View $view,
        array $attributes = [],
        array $errors = [],
        array $old = [],
        array $slots = [],
    ): void {
        $this->setViewAttributes($attributes);
        $this->setViewErrors($errors);
        $this->setRequestOld($old);

        foreach ($attributes as $key => $value) {
            $view->with($key, $value);
        }
        
        foreach ($slots as $slot) {
            $this->setViewSlot(
                $slot['name'] ?? '',
                    $slot['html'] ?? '',
                    $slot['data'] ?? [],
            );
        }

        $this->assertIsString(
            $view->render(),
            $view->name() . ' failed to render',
        );
    }

    public function assertMailRenders(
        Mailable $mail,
    ): void {
        $content = $mail->content();

        $this->assertIsString(
            $mail->render(),
            $content->markdown ?? $content->view . ' failed to render',
        );
    }

    public function assertNotificationRenders(
        Notification $notification,
        AnonymousNotifiable|Model|null $notifiable = null,
    ): void {
        $content = $notifiable === null
            ? $notification->toMail()
            : $notification->toMail($notifiable);

        $this->assertIsString(
            $content
                ->render()
                ->toHtml(),
            $content->markdown ?? $content->view . ' failed to render',
        );
    }
}
