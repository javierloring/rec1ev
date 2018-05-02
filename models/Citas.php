<?php

namespace app\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;

/**
 * This is the model class for table "citas".
 *
 * @property int $id
 * @property string $instante
 * @property int $usuario_id
 *
 * @property Usuarios $usuario
 */
class Citas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instante', 'usuario_id'], 'required'],
            [['instante'], 'safe'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instante' => 'Instante',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('citas');
    }

    /**
     * [siguiente description].
     * @return DateTime [description]
     */
    public static function siguiente(): DateTime
    {
        $ultima = static::find()->max('instante') ?? 'now';
        $zona = new DateTimeZone(Yii::$app->formatter->timeZone);

        $local = (new DateTime($ultima))->setTimeZone($zona)->format('H:i');

        if ($local == '20:45' || $ultima == 'now') {
            $siguiente = (new DateTime($ultima))
                ->setTimeZone($zona)
                ->add(new DateInterval('P1D'))
                ->setTime(10, 0, 0)
                ->setTimeZone('UTC');
        } else {
            $siguiente = (new DateTime($ultima))
                ->add(new DateInterval('PT15M'));
        }
        return $siguiente;
    }
}
