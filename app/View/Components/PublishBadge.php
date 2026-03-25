<?php
namespace App\View\Components;

use Illuminate\View\Component;

class PublishBadge extends Component
{
    public mixed $model;
    public string $column;

    public function __construct($model, string $column = 'is_published')
    {
        $this->model = $model;
        $this->column = $column;
    }

    public function isPublished(): bool
    {
        return (bool) data_get($this->model, $this->column);
    }

    public function render()
    {
        return view('components.publish-badge');
    }
}
