<?php namespace KSV\Form\Components;

use Cms\Classes\ComponentBase;
use KSV\Form\Models\Feedback as FeedbackModel;
use Mail;
use Input;
use Flash;

/**
 * Feedback Component
 */
class Feedback extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Форма обратной связи',
            'description' => 'Добавляет на страницу обработчик формы обратной связи'
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
        
        if(!Input::has('email') || empty(Input::get('email'))){
            $errorMessage = 'Вы должны указать e-mail для связи';
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => $errorMessage ]);
            Flash::error( 'Вы должны указать e-mail для связи' );
        }

        if(!Input::has('form_message') || empty(Input::get('form_message'))){
            $errorMessage = 'Вы должны заполнить поле "Сообщение"';
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => $errorMessage ]);
            Flash::error( 'Вы должны заполнить поле "Сообщение"' );
        }
        
        $data = [
            'name'       => e(Input::get('name')),
            'phone'      => e(Input::get('phone')),
            'email'      => e(Input::get('email')),
            'form_message'  => e(Input::get('form_message')),
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
            $feedback = new FeedbackModel();
            $feedback->fill($data);
            $feedback->save();
        } else {
            throw new \AjaxException([ 'X_OCTOBER_ERROR_MESSAGE' => 'Произошла ошибка, попробуйте позже' ]);
            Flash::error( 'Произошла ошибка при отправке формы' );
        }
    }
}
