<?php

namespace Botble\Reviews\Forms;

use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\FormAbstract;
use Botble\Reviews\Models\Review;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Html;

class ReviewForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Review::class)
            ->add('name', TextField::class, [
                'label' => 'Tên người đánh giá',
                'attr' => ['readonly' => true],
            ])
            ->add('rating', SelectField::class, SelectFieldOption::make()
                ->label('Đánh giá')
                ->choices([
                    1 => '1 Sao',
                    2 => '2 Sao',
                    3 => '3 Sao',
                    4 => '4 Sao',
                    5 => '5 Sao',
                ]))
            ->add('comment', TextareaField::class, ContentFieldOption::make()->label('Nội dung'))
            ->add('images_display', HtmlField::class, [
                'label' => 'Hình ảnh đính kèm',
                'html' => $this->getImagesHtml(),
            ])
            ->add('is_approved', SelectField::class, SelectFieldOption::make()
                ->label('Trạng thái')
                ->choices([
                    1 => 'Đã duyệt',
                    0 => 'Chờ duyệt',
                ]))
            ->setBreakFieldPoint('is_approved');
    }

    protected function getImagesHtml(): string
    {
        $model = $this->getModel();

        if (!$model || !$model->id) {
            return '<p class="text-muted">Không có hình ảnh</p>';
        }

        $images = $model->images;

        if (empty($images) || !is_array($images)) {
            return '<p class="text-muted">Không có hình ảnh</p>';
        }

        $html = '<div class="d-flex flex-wrap gap-2">';
        foreach ($images as $image) {
            if (!empty($image)) {
                $imageUrl = \Botble\Media\Facades\RvMedia::getImageUrl($image);
                $html .= '<a href="' . $imageUrl . '" target="_blank">';
                $html .= '<img src="' . $imageUrl . '" alt="Review image" style="max-width: 150px; max-height: 150px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">';
                $html .= '</a>';
            }
        }
        $html .= '</div>';

        return $html;
    }
}
