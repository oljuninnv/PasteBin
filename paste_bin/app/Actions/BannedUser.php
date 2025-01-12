<?php 
namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class BannedUser extends AbstractAction
{
    public function getTitle(): string
    {
        // Название действия, которое отображается в кнопке 
        return $this->data->banned ? 'Разблокировать' : 'Заблокировать';
    }

    public function getIcon(): string
    {
        // Значок действия, который отображается слева от кнопки 
        return $this->data->banned ? 'voyager-check' : 'voyager-x';
    }

    public function getAttributes(): array
    {
        // Класс кнопки действия
        return [
            'class' => 'btn btn-sm btn-primary pull-left',
        ];
    }

    public function shouldActionDisplayOnDataType(): bool
    {
        // Показывать или скрыть кнопку действия. Отображается только для модели Users
        return $this->dataType->slug == 'users';
    }

    public function getDefaultRoute(): string
    {
        // URL-адрес для кнопки действия при нажатии кнопки
        return route('users.ban', array("id" => $this->data->{$this->data->getKeyName()}));
    }
}