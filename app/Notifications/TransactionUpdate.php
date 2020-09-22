<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionUpdate extends Notification
{
    use Queueable;
    protected $transaction, $buyOrSell, $level;

    /**
     * Create a new notification instance.
     *
     * @param $transaction
     * @param $buyOrSell
     * @param $level
     */
    public function __construct($transaction, $buyOrSell, $level)
    {
        $this->transaction = $transaction;
        $this->buyOrSell = $buyOrSell;
        $this->level = $level;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {

        switch ($this->level){
            case 'create':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('درخواست معامله شما برای '.$this->transaction->s_user->name.' ارسال شد. تا پاسخ دهی ایشان شکیبا باشید.');
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('شما یک درخواست معامله از طرف '.$this->transaction->b_user->name.' دارید. لطفا به آن پاسخ دهید.')
                        ->action('پاسخ به درخواست', route('transactions.edit', $this->transaction->id));
                break;
            case 'reject':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('error')
                        ->line('درخواست معامله شما از طرف '.$this->transaction->s_user->name.' رد شد. شما می توانید آگهی های دیگر را امتحان کنید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('دیدن آگهی ها', route('home'));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('شما درخواست معامله از طرف '.$this->transaction->b_user->name.' را رد کردید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id);
                break;
            case 'accept':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('درخواست معامله شما از طرف '.$this->transaction->s_user->name.' پذیرفته شد. لطفا طبق دستورالعمل معامله را ادامه دهید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('دیدن دستورالعمل', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('شما درخواست معامله از طرف '.$this->transaction->b_user->name.' را پذیرفتید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id);
                break;
            case 'cancel':
                if($this->buyOrSell == 'buy'){
                    if($this->transaction->transState_id === 4 && $this->transaction->cancel_flag === 1)//cancel accepted
                        return (new MailMessage)
                            ->level('info')
                            ->line('درخواست لغو معامله پذیرفته شد. در اسرع وقت برگشت پول انجام می شود.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2)//cancel verification
                        return (new MailMessage)
                            ->level('info')
                            ->line('درخواست لغو معامله ارسال شد.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag === 2)//cancel rejected
                        return (new MailMessage)
                            ->level('error')
                            ->line('درخواست لغو معامله رد شد. شما باید معامله را ادامه دهید.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                }
                elseif ($this->buyOrSell == 'sell'){
                    if($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2 && $this->transaction->transLevel_id < 4 )//cancel verification
                        return (new MailMessage)
                            ->level('info')
                            ->line('برای این معامله از طرف خریدار درخواست لغو ارسال شده است. دیگر نیازی به ادامه آن نیست.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2 && $this->transaction->transLevel_id >= 4 )//cancel verification
                        return (new MailMessage)
                            ->level('info')
                            ->line('خریدار درخواست لغو این معامله را داده است. این درخواست فقط با تایید شما امکان پذیر است. تا پاسخ شما به این درخواست مبلغ پرداخت شده توسط خریدار، نزد سایت باقی می ماند.')
                            ->line('لطفا جواب خود را برای رد یا تایید این درخواست به آدرس زیر ایمیل کنید.')
                            ->line('cancel@example.com')
                            ->line('نکته1: کد رهگیری معامله را در ایمیل ذکر کنید.')
                            ->line('نکته2: حتما از ایمیلی که در سایت با آن حساب دارید، استفاده کنید.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                    elseif($this->transaction->transState_id === 4 && $this->transaction->cancel_flag === 1)//cancel accepted
                        return (new MailMessage)
                            ->level('info')
                            ->line('این معامله لغو شد.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag === 2)//cancel rejected
                        return (new MailMessage)
                            ->level('info')
                            ->line('لغو معامله از سمت شما پذیرفته نیست. لطفا طبق دستورالعمل ادامه دهید.')
                            ->line('کد رهگیری: '. $this->transaction->transaction_id);
                }
                if($this->buyOrSell == 'admin'){
                    return (new MailMessage)
                        ->level('info')
                        ->line('تاییدیه لغو معامله.');
                }
                break;
            case '1':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('پرداخت پول به سایت توسط '.$this->transaction->b_user->name.' در حال بررسی است.')
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('پرداخت پول به سایت توسط '.$this->transaction->b_user->name.' در حال بررسی است.')
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'admin')
                    return (new MailMessage)
                        ->level('info')
                        ->line('درخواست بررسی دریافت پول');
                break;
            case '2':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('پرداخت پول توسط شما تایید شد. لطفا مشخصات حساب بانکی مربوط به '.$this->transaction->s_country->name.' را ارائه دهید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('ارائه مشخصات حساب', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('پرداخت پول به سایت توسط '.$this->transaction->b_user->name.' تایید شد. تا دریافت مشخصات حساب بانکی '.$this->transaction->b_user->name.' صبور باشید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                break;
            case '3':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('اطلاعات حساب شما برای '.$this->transaction->s_user->name.' ارسال شد.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('اطلاعات حساب '. $this->transaction->b_user->name .' دریافت شد. لطفا مبلغ خواسته شده را به آن واریز نمایید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('مشاهده اطلاعات حساب', route('transactions.edit', $this->transaction->id));
                break;
            case '4':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line($this->transaction->s_user->name.' تایید کرده که برای شما پول واریز کرده است. بعد از دریافت پول ما را مطلع کنید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('مطلع کردن ما', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line($this->transaction->b_user->name .' از ارسال پول شما مطلع شد. تا تایید ایشان صبور باشید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                break;
            case '5':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('info')
                        ->line('شما دریافت پول از '. $this->transaction->s_user->name .' را تایید کردید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line($this->transaction->b_user->name .' دریافت پول از شما را تایید کرد. لطفا اطلاعات حساب بانکی مربوط به '. $this->transaction->b_country->name .' را ارائه دهید.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('ارائه مشخصات حساب', route('transactions.edit', $this->transaction->id));
                break;
            case '6':
                if($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('info')
                        ->line('اطلاعات حساب شما دریافت شد.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'admin')
                    return (new MailMessage)
                        ->level('info')
                        ->line('درخواست پرداخت پول');
                break;
            case '7':
                return (new MailMessage)
                    ->level('info')
                    ->line('سایت پول را به حساب شما واریز کرد. در صورت دریافت آن را تایید کنید.')
                    ->line('کد رهگیری: '. $this->transaction->transaction_id)
                    ->action('تایید دریافت پول', route('transactions.edit', $this->transaction->id));
                break;
            case '8':
                if($this->buyOrSell == 'buy')
                    return (new MailMessage)
                        ->level('success')
                        ->line('معامله شما با موفقیت پایان یافت.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                elseif ($this->buyOrSell == 'sell')
                    return (new MailMessage)
                        ->level('success')
                        ->line('معامله شما با موفقیت پایان یافت.')
                        ->line('کد رهگیری: '. $this->transaction->transaction_id)
                        ->action('وضعیت معامله', route('transactions.edit', $this->transaction->id));
                break;
        }

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        switch ($this->level) {
            case 'create':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'ارسال درخواست برای '.$this->transaction->s_user->name.'.'
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'درخواست جدید از طرف ' . $this->transaction->b_user->name . '.'
                    ];
                break;
            case 'reject':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => $this->transaction->s_user->name . ' درخواست شما را رد کرد.',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'شما درخواست ' . $this->transaction->b_user->name . ' را رد کردید.'
                    ];
                break;
            case 'accept':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => $this->transaction->s_user->name . ' درخواست شما را پذیرفت.',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'شما درخواست ' . $this->transaction->b_user->name . ' را پذیرفتید.'
                    ];
                break;
            case 'cancel':
                if ($this->buyOrSell == 'buy'){
                    if($this->transaction->transState_id === 4 && $this->transaction->cancel_flag === 1)//cancel accepted
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'درخواست لغو پذیرفته شد.',
                        ];
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2)//cancel verification
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'درخواست لغو ارسال شد.',
                        ];
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag === 2)//cancel rejected
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'درخواست لغو رد شد.',
                        ];
                }
                elseif ($this->buyOrSell == 'sell'){
                    if($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2 && $this->transaction->transLevel_id < 4 )//cancel verification
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'درخواست لغو معامله.',
                        ];
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag != 2 && $this->transaction->transLevel_id >= 4 )//cancel verification
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'درخواست لغو معامله.',
                        ];
                    elseif($this->transaction->transState_id === 4 && $this->transaction->cancel_flag === 1)//cancel accepted
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'معامله لغو شد.',
                        ];
                    elseif($this->transaction->transState_id != 4 && $this->transaction->cancel_flag === 2)//cancel rejected
                        return [
                            'transaction_id' => $this->transaction->id,
                            'message' => 'رد درخواست لغو.',
                        ];
                }
                elseif ($this->buyOrSell == 'admin'){
                    return [
                        'transaction_id' => $this->transaction->id,
                        'flag' => 'cancel',
                        'message' => 'تاییدیه لغو معامله',
                    ];
                }
                break;
            case '1':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'در حال بررسی پرداخت پول',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'در حال بررسی پرداخت پول',
                    ];
                elseif ($this->buyOrSell == 'admin')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'flag' => 'rcv',
                        'message' => 'تاییدیه دریافت پول',
                    ];
                break;
            case '2':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'دریافت پول از شما تایید شد.',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'دریافت پول از '. $this->transaction->b_user->name .' مورد تایید است.',
                    ];
                break;
            case '3':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'مشخصات دریافت شد.',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'لطفا پول را واریز نمایید.',
                    ];
                break;
            case '4':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'آیا پول را دریافت کردید؟',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => $this->transaction->b_user->name.' از واریز پول مطلع شد.',
                    ];
                break;
            case '5':
                if ($this->buyOrSell == 'buy')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'تایید دریافت پول',
                    ];
                elseif ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'مشخصات حساب خود را وارد کنید.',
                    ];
                break;
            case '6':
                if ($this->buyOrSell == 'sell')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'message' => 'مشخصات حساب دریافت شد.',
                    ];
                elseif ($this->buyOrSell == 'admin')
                    return [
                        'transaction_id' => $this->transaction->id,
                        'flag' => 'pay',
                        'message' => 'تاییدیه پرداخت پول',
                    ];
                break;
            case '7':
                return [
                    'transaction_id' => $this->transaction->id,
                    'message' => 'آیا پول را دریافت کردید؟',
                ];
                break;
            case '8':
                return [
                    'transaction_id' => $this->transaction->id,
                    'message' => 'معامله با موفقیت پایان یافت.',
                ];
                break;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
