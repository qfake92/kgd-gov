<?php namespace frontend\controllers;

use app\forms\parser\InnRequestForm;
use common\models\Debtor;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParserController extends Controller
{
	/**
	 * @return string
	 * @throws \Throwable
	 */
	public function actionParsing()
	{
		$form = new InnRequestForm();

		if ($form->fetchData(Yii::$app->request->post())) {
			return $this->render('parsing-result', [
				'debtor'    => $form->result,
				'formModel' => $form,
			]);
		}

		return $this->render('parsing', ['model' => $form]);
	}

	/**
	 * @return string
	 */
	public function actionListSaved()
	{
		$provider = new ActiveDataProvider([
			'query' => Debtor::find()
		]);

		return $this->render('list-saved', ['dataProvider' => $provider]);
	}

	/**
	 * @param $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionViewSaved($id)
	{
		$model = Debtor::find()
			->with(['arrears', 'arrears.type', 'arrears.department'])
			->where(['id' => $id])
			->one();

		if ($model === null) {
			throw new NotFoundHttpException();
		}

		return $this->render('view-saved', ['debtor' => $model]);
	}
}