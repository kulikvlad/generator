<?php

namespace app\controllers;

use app\models\Charts;
use app\models\Form;
use app\models\Generator;
use app\models\GeneratorChart;
use app\models\Payments;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Form();
        $charts = Charts::find()->orderBy('ID ASC')->all();

        if(Yii::$app->request->isPost){

            $generator = new GeneratorChart();

            $generator->setDate($_POST['Form']['date']);
            $generator->setNumberMonths($_POST['Form']['numberMonths']);
            $generator->setAmount($_POST['Form']['amount']);
            $generator->setInterestRate($_POST['Form']['interestRate']);

            // the run() function of the generatorChart () model returns the identifier of the chart for which it generated payments
            $chartId = $generator->run();


            $chart = Charts::findOne($chartId);
            $payments = Payments::find()->where(['chart_id'=>$chartId])->orderBy('NUMBER ASC')->all();
            return $this->render('chart', ['payments'=>$payments,'chart'=>$chart]);
        }

        if(isset($_GET['id']))
        {
            $chart = Charts::findOne($_GET['id']);
            $payments = Payments::find()->where(['chart_id'=>$_GET['id']])->orderBy('NUMBER ASC')->all();
            return $this->render('chart', ['payments'=>$payments,'chart'=>$chart]);
        }

        return $this->render('form', [
            'model' => $model,
            'charts' => $charts,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
