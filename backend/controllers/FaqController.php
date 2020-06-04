<?php

namespace common\modules\faq\backend\controllers;

use Yii;
use backend\actions\SwitchStatusAction;
use common\actions\DeleteImageAction;
use common\actions\ChangePosAction;
use common\helpers\Image;
use common\modules\faq\backend\models\FaqSearch;
use common\modules\faq\common\models\Faq;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class FaqController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'switch-status' => ['POST'],
                    'change-pos' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'switch-status' => [
                'class' => SwitchStatusAction::className(),
                'modelClass' => Faq::className(),
                'statusOn'=> Faq::STATUS_ACTIVE,
                'statusOff' => Faq::STATUS_INACTIVE,
            ],
            'delete-image' => [
                'class' => DeleteImageAction::className(),
                'modelClass' => Faq::className(),
                'attribute' => 'image',
            ],
            'change-pos' => [
                'class' => ChangePosAction::className(),
                'modelClass' => Faq::className(),
                'attribute' => 'pos',
                'mess' => 'question',
            ]
        ];
    }

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Faq();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            foreach (Yii::$app->request->post('FaqTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('backend/material', 'Material "{item}" successfully created', ['item' => $model->translate(Yii::$app->config->get('materialsLanguage'))->question]));
                if (! Yii::$app->request->post('refresh')) {
                    return $this->redirect(Url::previous());
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach (Yii::$app->request->post('FaqTranslation', []) as $language => $data) {

                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                }
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('backend/material', 'Material "{item}" successfully updated', ['item' => $model->translate(Yii::$app->config->get('materialsLanguage'))->question]));
                if (! Yii::$app->request->post('refresh')) {
                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faq::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
