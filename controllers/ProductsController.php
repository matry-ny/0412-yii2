<?php

namespace app\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Yii;
use app\models\Product;
use app\models\search\ProductSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Product model.
 */
class ProductsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['viewProductsList']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewProduct']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['addProduct']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateProduct']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'matchCallback' => function() {
                            $productId = Yii::$app->getRequest()->get('id');
                            return Yii::$app->getUser()->can('deleteProduct') ||
                                Yii::$app->getUser()->can('deleteOwnProduct', [
                                    'product' => $this->findModel($productId)
                                ]);
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['export'],
                        'roles' => ['exportProducts']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->created_by = Yii::$app->getUser()->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionExport()
    {
        $spreadsheet = new Spreadsheet();

        $newSheet = new Worksheet($spreadsheet, 'Test');
        $spreadsheet->addSheet($newSheet);
        $spreadsheet->setActiveSheetIndexByName('Test');

        $sheet = $spreadsheet->getActiveSheet();

        foreach (Product::find()->each() as $index => $product) {
            /** @var Product $product */
            $keys = array_keys($product->getAttributes());
            foreach ($product->getAttributes() as $key => $value) {
                $column = array_search($key, $keys) + 1;
                $row = $index + 1;
                $sheet->setCellValueByColumnAndRow($column, $row, $value);
            }
        }

        $writer = new Csv($spreadsheet);
        $writer->save(Yii::getAlias('@runtime/products.csv'));
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
