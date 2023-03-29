<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class PelaporanForm extends Model
{
    public $jenis_laporan;
    public $tahun_laporan;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['jenis_laporan', 'tahun_laporan'], 'required'],
        ];
    }
}
