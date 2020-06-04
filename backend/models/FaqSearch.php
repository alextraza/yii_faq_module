<?php

namespace common\modules\faq\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\faq\common\models\Faq;
use common\modules\faq\common\models\FaqTranslation;

/**
 * ReviewSearch represents the model behind the search form about `common\modules\guestbook\models\Review`.
 */
class FaqSearch extends Faq
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'pos', 'created_at', 'updated_at'], 'integer'],
            [['question', 'answer'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Faq::find();

        $query->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['question'] = [

            'asc' => [FaqTranslation::tableName() . '.question' => SORT_ASC],
            'desc' => [FaqTranslation::tableName() . '.question' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['answer'] = [

            'asc' => [FaqTranslation::tableName() . '.answer' => SORT_ASC],
            'desc' => [FaqTranslation::tableName() . '.answer' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
