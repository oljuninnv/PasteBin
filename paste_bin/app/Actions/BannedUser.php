<?php 

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class BannedUser extends AbstractAction
{
    public function getTitle(): string
    {
        return $this->data->banned ? 'Разблокировать' : 'Заблокировать';
    }

    public function getIcon(): string
    {
        return $this->data->banned ? 'voyager-check' : 'voyager-x';
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-left',
        ];
    }

    public function shouldActionDisplayOnDataType(): bool
    {
        return $this->dataType->slug == 'users';
    }

    public function getDefaultRoute(): string
    {
        return route('users.ban', array("id" => $this->data->{$this->data->getKeyName()}));
    }
}