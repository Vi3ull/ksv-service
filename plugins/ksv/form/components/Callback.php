<?php namespace KSV\Form\Components;

use Cms\Classes\ComponentBase;
use KSV\Form\Models\Callback as CallbackModel;
use Mail;
use Input;
use Flash;

/**
 * Callback Component
 */
class Callback extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Форма обратного звонка',
            'description' => 'Добавляет на страницу обработчик формы обратного звонка'
        ];
    }

    public function defineProperties()
    {
        return [
            'email' => [
                'title'       => 'Email',
                'description' => 'Данный email будет использоваться для отправки всех заявок с формы.',
                'default'     => 'info@example.com',
                'required'    => true,
            ],
        ];
    }

    public function onSend() 
    {
        if(!Input::has('name') || empty(Input::get('name'))){
            $errorMessage = 'Вы должны указать свое имя!';
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => $errorMessage ]);
            Flash::error( $errorMessage );
        }

        if(!Input::has('phone') || empty(Input::get('phone'))){
            $errorMessage = 'Вы должны указать телефон для связи!';
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => $errorMessage ]);
            Flash::error( 'Вы должны указать телефон для связи!' );
        }
        

        $data = [
            'name'       => e(Input::get('name')),
            'phone'      => e(Input::get('phone'))
        ];
        
        if(Input::has('phone') && !empty(Input::get('phone'))){
            $data['phone'] = e(Input::get('phone'));
        }

        $email = $this->property('email');
        Mail::send('ksv.form::mail.feedback', $data, function($message) use ($email) {
            $message->to($email, 'Admin Person');
        });

        if (count(Mail::failures()) == 0){
            Flash::success( 'Форма успешно отправлена!' );
            $callback = new CallbackModel();
            $callback->fill($data);
            $callback->save();
        } else {
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => 'Произошла ошибка, попробуйте позже' ]);
            Flash::error( 'Произошла ошибка при отправке формы' );
        }
    }
}
