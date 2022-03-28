<?php
/**
 *  app/Models/Translations/ServiceTranslation.php
 *
 * Date-Time: 06.08.21
 * Time: 14:53
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends BaseTranslationModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        "subtitle_1",
        "subtitle_2",
        "content_1",
        "content_2",
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];

}
