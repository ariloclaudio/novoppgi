<?php
namespace frontend\controllers;

use Yii;
use app\models\Candidato;
use app\models\Edital;
use PHPExcel;
use frontend\models\LoginForm;
use common\models\LinhaPesquisa;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
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
     * @inheritdoc
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
     * @return mixed
     */
    public function actionIndex()
    {

        $this->actionTesteplanilha();


        $this->layout = '@app/views/layouts/main-login.php';
        $model = new Candidato();
        return $this->render('opcoes',['model' => $model,
            ]);
    }
    
    
    public function planilhaCandidatoFormatacao($objPHPExcel,$intervalo_tamanho){

    //definindo a altura das linhas

    $qtd_linhas = $objPHPExcel->getActiveSheet()->getHighestRow();

    for ($i=1; $i<=$qtd_linhas; $i++){
        $objPHPExcel->getActiveSheet()->getRowDimension(''.$i.'')->setRowHeight(20);
    }

    // Centralizando o valor nas colunas

        $objPHPExcel->getActiveSheet()->getStyle( $intervalo_tamanho )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle( $intervalo_tamanho )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //auto break line
        
        $objPHPExcel->getActiveSheet()
            ->getStyle($intervalo_tamanho)
            ->getAlignment()
            ->setWrapText(true);


          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $objPHPExcel->getActiveSheet()->getStyle($intervalo_tamanho)->applyFromArray($BStyle);

    // Configurando diferentes larguras para as colunas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

    }
    
    //método responsável por preencher na planilha os títulos: NOME/INSCRIÇÃO/LINHA/NÍVEL/COMPROVANTE/ ETC.
    
    public function planilhaHeaderCandidato ($objPHPExcel,$arrayColunas,$curso,$intervaloHeader){
    
        // Criamos as colunas
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($arrayColunas[0], $curso )
                ->setCellValue($arrayColunas[1], "Nome" )
                ->setCellValue($arrayColunas[2], "Inscrição" )
                ->setCellValue($arrayColunas[3], "Linha" )
                ->setCellValue($arrayColunas[4], "Nível" )
                ->setCellValue($arrayColunas[5], "Comprovante" )
                ->setCellValue($arrayColunas[6], "Curriculum" )
                ->setCellValue($arrayColunas[7], "Histórico" )
                ->setCellValue($arrayColunas[8], "Proposta" )
                ->setCellValue($arrayColunas[9], "Cartas \n(2 no mínimo)" )
                ->setCellValue($arrayColunas[10], "Homologado" )
                ->setCellValue($arrayColunas[11], "Observações");

        //mesclando celulas

        $objPHPExcel->getActiveSheet()->mergeCells($intervaloHeader);

        //colocando os títulos em Negrito

        $objPHPExcel->getActiveSheet()->getStyle($intervaloHeader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($arrayColunas[1].":".$arrayColunas[11])->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()
            ->getStyle($intervaloHeader)
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $objPHPExcel->getActiveSheet()->getStyle($intervaloHeader)->getFont()->getColor()->setRGB('FFFFFF');


                
    }

    //método responsável por preencher na planilha dados provenientes do banco: NOME/INSCRIÇÃO/LINHA/NÍVEL

    public function planilhaCandidatoPreencherDados($objPHPExcel,$model_candidato_doutorado,$linhasPesquisas,$arrayCurso,$i,$j){


        for($j=0; $j<count($model_candidato_doutorado); $j++){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+3, $model_candidato_doutorado[$j]->nome);
            
            $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(1, $i+3, ($model_candidato_doutorado[$j]->idEdital.'-'.str_pad($model_candidato_doutorado[$j]->posicaoEdital, 3, "0", STR_PAD_LEFT)));
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+3, $linhasPesquisas[$model_candidato_doutorado[$j]->idLinhaPesquisa]);

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i+3, $arrayCurso[$model_candidato_doutorado[$j]->cursodesejado]);   

            $i++;
        }

        return $i;
    }

    public function planilhaProvasFormatacao($objWorkSheet,$intervalo_tamanho){


        $objWorkSheet->mergeCells("A1:C1");

        $objWorkSheet->getStyle("A1:C2")->getFont()->setBold(true);


        $objWorkSheet->getStyle( $intervalo_tamanho )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle( $intervalo_tamanho )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $objWorkSheet->getColumnDimension('A')->setWidth(40);
        $objWorkSheet->getColumnDimension('B')->setWidth(15);
        $objWorkSheet->getColumnDimension('C')->setWidth(18);

        $objWorkSheet
                ->setCellValue("A1", "Mestrado" )
                ->setCellValue("A2", "Nome" )
                ->setCellValue("B2", "Inscrição" )
                ->setCellValue("C2", "Nota Final" );


          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $objWorkSheet->getStyle($intervalo_tamanho)->applyFromArray($BStyle);
    }

    public function planilhaProvas($objWorkSheet,$linhaAtual,$ultimaLinha){


        //definindo altura da linha do header
        $objWorkSheet->getRowDimension(2)->setRowHeight(40);

        //Write cells
        for ($i=0; $i< $linhaAtual; $i++){

            $objWorkSheet
                ->setCellValue('A'.($i+3), "='Candidato'!A".($i+3))
                ->setCellValue('B'.($i+3), "='Candidato'!B".($i+3));
        }

        $i = $i+4;

        $objWorkSheet
                ->setCellValue("A".($i-1), "Doutorado" )
                ->setCellValue("A".($i), "Nome" )
                ->setCellValue("B".($i), "Inscrição" )
                ->setCellValue("C".($i), "Nota Final" );

        $objWorkSheet->getStyle("A".($i-1).":C".$i)->getFont()->setBold(true);

        $objWorkSheet->mergeCells("A".($i-1).":C".($i-1));

        //definindo a cor de fundo e cor da fonte do título do header: mestrado

        $objWorkSheet
            ->getStyle("A1:C1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $objWorkSheet->getStyle("A1:C1")->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a cor de fundo e cor da fonte do título do header: doutorado


        $objWorkSheet
            ->getStyle("A".($i-1).":C".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $objWorkSheet->getStyle("A".($i-1).":C".($i-1))->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a linha do segundo header!
        $linhaSegundoHeader = $i;

        //Write cells
        for ($i=$i+1; $i< $ultimaLinha+3; $i++){

            $objWorkSheet
                ->setCellValue('A'.($i), "='Candidato'!A".($i))
                ->setCellValue('B'.($i), "='Candidato'!B".($i));
        }

        //definindo tamanho das linhas
        $qtd_linhas = $objWorkSheet->getHighestRow();
        for ($k=1; $k<=$qtd_linhas; $k++){
            $objWorkSheet->getRowDimension(''.$k.'')->setRowHeight(20);
            
        }

        //definindo altura da linha do header
        $objWorkSheet->getRowDimension(2)->setRowHeight(40);
        $objWorkSheet->getRowDimension($linhaSegundoHeader)->setRowHeight(40);

        // Rename sheet
        $objWorkSheet->setTitle("Provas");

    }

    public function planilhaPropostasFormatacao($planilhaPropostas,$intervalo_tamanho){

        //define a página como formato em RETRATO

        $planilhaPropostas->getPageSetup()
            ->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $planilhaPropostas->mergeCells("A1:E1");

        $planilhaPropostas->getStyle("A1:E2")->getFont()->setBold(true);


        //definindo altura da linha do header
        $planilhaPropostas->getRowDimension(1)->setRowHeight(20);
        $planilhaPropostas->getRowDimension(2)->setRowHeight(40);

        $planilhaPropostas->getStyle( $intervalo_tamanho )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $planilhaPropostas->getStyle( $intervalo_tamanho )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $planilhaPropostas->getColumnDimension('A')->setWidth(40);
        $planilhaPropostas->getColumnDimension('B')->setWidth(13);
        $planilhaPropostas->getColumnDimension('C')->setWidth(13);
        $planilhaPropostas->getColumnDimension('D')->setWidth(13);
        $planilhaPropostas->getColumnDimension('E')->setWidth(13);

        $planilhaPropostas
                ->setCellValue("A1", "Mestrado" )
                ->setCellValue("A2", "Nome" )
                ->setCellValue("B2", "Avaliador 1" )
                ->setCellValue("C2", "Avaliador 2" )
                ->setCellValue("D2", "Avaliador 3" )
                ->setCellValue("E2", "Média Final" );


          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $planilhaPropostas->getStyle($intervalo_tamanho)->applyFromArray($BStyle);

    }

    public function planilhaPropostas($planilhaPropostas,$linhaAtual,$ultimaLinha){



        //Write cells
        for ($i=0; $i< $linhaAtual; $i++){

            $planilhaPropostas
                ->setCellValue('A'.($i+3), "='Candidato'!A".($i+3))
                ->setCellValue('E'.($i+3), '=AVERAGE(B'.($i+3).':D'.($i+3).')');
        }

        $i = $i+4;

        $planilhaPropostas
                ->setCellValue("A".($i-1), "Doutorado" )
                ->setCellValue("A".($i), "Nome" )
                ->setCellValue("B".($i), "Avaliador 1" )
                ->setCellValue("C".($i), "Avaliador 2" )
                ->setCellValue("D".($i), "Avaliador 3" )
                ->setCellValue("E".($i), "Média Final" );

        $planilhaPropostas->getStyle("A".($i-1).":E".$i)->getFont()->setBold(true);

        $planilhaPropostas->mergeCells("A".($i-1).":E".($i-1));

        //definindo a cor de fundo e cor da fonte do título do header: mestrado

        $planilhaPropostas
            ->getStyle("A1:C1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaPropostas->getStyle("A1:C1")->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a cor de fundo e cor da fonte do título do header: doutorado


        $planilhaPropostas
            ->getStyle("A".($i-1).":C".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaPropostas->getStyle("A".($i-1).":C".($i-1))->getFont()->getColor()->setRGB('FFFFFF');

        $linhaSegundoHeader = $i;

        //Write cells
        for ($i=$i+1; $i< $ultimaLinha+3; $i++){

            $planilhaPropostas
                ->setCellValue('A'.($i), "='Candidato'!A".($i))
                ->setCellValue('E'.($i), '=AVERAGE(B'.($i).':D'.($i).')');
        }


        //definindo tamanho das linhas
        $qtd_linhas = $planilhaPropostas->getHighestRow();
        for ($k=1; $k<=$qtd_linhas; $k++){
            $planilhaPropostas->getRowDimension(''.$k.'')->setRowHeight(20);
        }

        //definindo altura da linha do header

        $planilhaPropostas->getRowDimension($linhaSegundoHeader)->setRowHeight(40);

        $planilhaPropostas->setTitle("Propostas");

    }

    public function planilhaTitulosFormatacao($planilhaTitulos,$intervalo_tamanho){


        $planilhaTitulos->mergeCells("A1:J1");
        $planilhaTitulos->mergeCells("A2:A3");

        $planilhaTitulos->mergeCells("B2:E2");
        $planilhaTitulos->mergeCells("F2:H2");

        $planilhaTitulos->mergeCells("I2:I3");
        $planilhaTitulos->mergeCells("J2:J3");

        $planilhaTitulos->getStyle("A1:J2")->getFont()->setBold(true);


        $planilhaTitulos->getRowDimension(3)->setRowHeight(40);

        //definindo altura da linha do header
        $planilhaTitulos->getRowDimension(1)->setRowHeight(20);
        $planilhaTitulos->getRowDimension(2)->setRowHeight(20);

        $planilhaTitulos->getStyle( $intervalo_tamanho )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $planilhaTitulos->getStyle( $intervalo_tamanho )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //auto break line
        
        $planilhaTitulos
            ->getStyle( $intervalo_tamanho )
            ->getAlignment()
            ->setWrapText(true);


        $planilhaTitulos->getColumnDimension('A')->setWidth(40);
        $planilhaTitulos->getColumnDimension('B')->setWidth(15);
        $planilhaTitulos->getColumnDimension('C')->setWidth(18);

        $planilhaTitulos
                ->setCellValue("A1", "Mestrado" )
                ->setCellValue("A2", "Nome" )
                ->setCellValue("B2", "Atividades Curriculares e Extracurriculares (30 pontos)" )
                ->setCellValue("F2", "Publicações (70 pontos)" )
                ->setCellValue("B3", "Mestrado" )
                ->setCellValue("C3", "Estágio, Extensão e monitoria" )
                ->setCellValue("D3", "Docência" )
                ->setCellValue("E3", "IC, IT, ID" )
                ->setCellValue("F3", "A" )
                ->setCellValue("G3", "B1 a B2" )
                ->setCellValue("H3", "B3 a B5" )
                ->setCellValue("I2", "Nota" )
                ->setCellValue("J2", "NAC" );

          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $planilhaTitulos->getStyle($intervalo_tamanho)->applyFromArray($BStyle);

    }

    public function planilhaTitulos($planilhaTitulos,$linhaAtual,$ultimaLinha){


        //Write cells
        for ($i=0; $i< $linhaAtual; $i++){

            $soma1 = "SUM(".'B'.($i+4).':E'.($i+4).")";
            $soma2 = "SUM(".'F'.($i+4).':H'.($i+4).")";

            $planilhaTitulos
                ->setCellValue('A'.($i+4), "='Candidato'!A".($i+3))
                ->setCellValue('J'.($i+4), '=5+((5 * I'.($i+4).')/100)')
                ->setCellValue('I'.($i+4), '=IF('.$soma1.'>30,30,'.$soma1.')'.' + IF('.$soma2.'>70,70,'.$soma2.')');

        }

        $i = $i+5;

        $planilhaTitulos->mergeCells("I".($i).":"."I".($i+1));

        $planilhaTitulos
                ->setCellValue("A".($i-1), "Doutorado" )
                ->setCellValue("A".($i), "Nome" )
                ->setCellValue("B".($i), "Atividades Curriculares e Extracurriculares (30 pontos)" )
                ->setCellValue("F".($i), "Publicações (70 pontos)" )
                ->setCellValue("B".($i+1), "Mestrado" )
                ->setCellValue("C".($i+1), "Estágio, Extensão e monitoria" )
                ->setCellValue("D".($i+1), "Docência" )
                ->setCellValue("E".($i+1), "IC, IT, ID" )
                ->setCellValue("F".($i+1), "A" )
                ->setCellValue("G".($i+1), "B1 a B2" )
                ->setCellValue("H".($i+1), "B3 a B5" )
                ->setCellValue("I".($i), "Nota" );

        $planilhaTitulos->getStyle("A".($i-1).":J".$i)->getFont()->setBold(true);

        $planilhaTitulos->mergeCells("A".($i-1).":J".($i-1));

        $planilhaTitulos->mergeCells("A".($i).":A".($i+1));

        $planilhaTitulos->mergeCells("B".($i).":E".($i));

        $planilhaTitulos->mergeCells("F".($i).":H".($i)); 

        //definindo qual linha da planilha se encontra o proximo header

        $linhaSegundoHeader = $i+1;

        //definindo a cor de fundo e cor da fonte do título do header: mestrado

        $planilhaTitulos
            ->getStyle("A1:C1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaTitulos->getStyle("A1:C1")->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a cor de fundo e cor da fonte do título do header: doutorado



        $planilhaTitulos
            ->getStyle("A".($i-1).":C".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaTitulos->getStyle("A".($i-1).":C".($i-1))->getFont()->getColor()->setRGB('FFFFFF');


        //Write cells
        for ($i; $i< $ultimaLinha+3; $i++){

            $soma1 = "SUM(".'B'.($i+2).':E'.($i+2).")";
            $soma2 = "SUM(".'F'.($i+2).':H'.($i+2).")";

            $planilhaTitulos
                ->setCellValue('A'.($i+2), "='Candidato'!A".($i))
                ->setCellValue('I'.($i+2), '=IF('.$soma1.'>30,30,'.$soma1.')'.' + IF('.$soma2.'>70,70,'.$soma2.')');;
        }


        $qtd_linhas = $planilhaTitulos->getHighestRow();

       
        for ($k=1; $k<=$qtd_linhas; $k++){
            $planilhaTitulos->getRowDimension(''.$k.'')->setRowHeight(20);
        }

        //definindo altura da linha do header
        $planilhaTitulos->getRowDimension($linhaSegundoHeader)->setRowHeight(40);


        // Rename sheet
        $planilhaTitulos->setTitle("Títulos");

    }

    public function planilhaCartasFormatacao($planilhaCartas,$intervalo_tamanho){

        $planilhaCartas->mergeCells("B1:L1");
        $planilhaCartas->mergeCells("M1:W1");

        $planilhaCartas->getColumnDimension('A')->setWidth(40);
        $planilhaCartas->getColumnDimension('X')->setWidth(20);


        $planilhaCartas->getStyle("A1:X2")->getFont()->setBold(true);

        $planilhaCartas->getStyle( $intervalo_tamanho )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $planilhaCartas->getStyle( $intervalo_tamanho )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



        $planilhaCartas
                ->setCellValue("A1", "Mestrado" )
                ->setCellValue("B1", "Avaliador 1" )
                ->setCellValue("M1", "Avaliador 2" )
                ->setCellValue("A2", "Candidato" )
                ->setCellValue("B2", "Dom" )
                ->setCellValue("C2", "Facil" )
                ->setCellValue("D2", "Assid" )
                ->setCellValue("E2", "Relac" )
                ->setCellValue("F2", "Iniciativa" )
                ->setCellValue("G2", "Escrita" )
                ->setCellValue("H2", "Inglês" )
                ->setCellValue("I2", "AC" )
                ->setCellValue("J2", "RA" )
                ->setCellValue("K2", "PI" )
                ->setCellValue("L2", "NICR" )
                ->setCellValue("M2", "Dom" )
                ->setCellValue("N2", "Facil" )
                ->setCellValue("O2", "Assid" )
                ->setCellValue("P2", "Relac" )
                ->setCellValue("Q2", "Iniciativa" )
                ->setCellValue("R2", "Escrita" )
                ->setCellValue("S2", "Inglês" )
                ->setCellValue("T2", "AC" )
                ->setCellValue("U2", "RA" )
                ->setCellValue("V2", "PI" )
                ->setCellValue("W2", "NICR" )
                ->setCellValue("X2", "Média Final" );

          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $planilhaCartas->getStyle($intervalo_tamanho)->applyFromArray($BStyle);

    }

    public function planilhaCartas($planilhaCartas,$linhaAtual,$ultimaLinha){


        //Write cells
        for ($i=0; $i< $linhaAtual; $i++){

            $formulaAC = "=SUM(".'B'.($i+3).':H'.($i+3).")";
            $formulaAC2 = "=SUM(".'M'.($i+3).':S'.($i+3).")";
            $formulaNICR = "=((I".($i+3)." * J".($i+3).")/10)+K".($i+3);
            $formulaNICR2 = "=((T".($i+3)." * U".($i+3).")/10)+V".($i+3);

            $planilhaCartas
                ->setCellValue('A'.($i+3), "='Candidato'!A".($i+3))
                ->setCellValue('I'.($i+3), $formulaAC)
                ->setCellValue('L'.($i+3), $formulaNICR)
                ->setCellValue('T'.($i+3), $formulaAC2)
                ->setCellValue('W'.($i+3), $formulaNICR2)
                ->setCellValue('X'.($i+3), '=(L'.($i+3).' + W'.($i+3).')')
                ;
        }

        $i = $i+4;


        $planilhaCartas
                ->setCellValue("A".($i-1), "Doutorado" )
                ->setCellValue("B".($i-1), "Avaliador 1" )
                ->setCellValue("M".($i-1), "Avaliador 2" )
                ->setCellValue("A".($i), "Candidato" )
                ->setCellValue("B".($i), "Dom" )
                ->setCellValue("C".($i), "Facil" )
                ->setCellValue("D".($i), "Assid" )
                ->setCellValue("E".($i), "Relac" )
                ->setCellValue("F".($i), "Iniciativa" )
                ->setCellValue("G".($i), "Escrita" )
                ->setCellValue("H".($i), "Inglês" )
                ->setCellValue("I".($i), "AC" )
                ->setCellValue("J".($i), "RA" )
                ->setCellValue("K".($i), "PI" )
                ->setCellValue("L".($i), "NICR" )
                ->setCellValue("M".($i), "Dom" )
                ->setCellValue("N".($i), "Facil" )
                ->setCellValue("O".($i), "Assid" )
                ->setCellValue("P".($i), "Relac" )
                ->setCellValue("Q".($i), "Iniciativa" )
                ->setCellValue("R".($i), "Escrita" )
                ->setCellValue("S".($i), "Inglês" )
                ->setCellValue("T".($i), "AC" )
                ->setCellValue("U".($i), "RA" )
                ->setCellValue("V".($i), "PI" )
                ->setCellValue("W".($i), "NICR" )
                ->setCellValue("X".($i), "Média Final" );

        $planilhaCartas->getStyle("A".($i-1).":X".$i)->getFont()->setBold(true);

        $planilhaCartas->mergeCells("B".($i-1).":L".($i-1));
        $planilhaCartas->mergeCells("M".($i-1).":W".($i-1));

        //definindo linha do segundo header
        $linhaSegundoHeader = $i;


        //definindo a cor de fundo e cor da fonte do título do header: mestrado

        $planilhaCartas
            ->getStyle("A1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaCartas->getStyle("A1")->getFont()->getColor()->setRGB('FFFFFF');

        $planilhaCartas
            ->getStyle("B1:W1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('DEB887');

        $planilhaCartas->getStyle("A1")->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a cor de fundo e cor da fonte do título do header: doutorado


        $planilhaCartas
            ->getStyle("A".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaCartas->getStyle("A".($i-1))->getFont()->getColor()->setRGB('FFFFFF');

        $planilhaCartas
            ->getStyle("B".($i-1).":W".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('DEB887');

        $planilhaCartas->getStyle("B".($i-1).":W".($i-1))->getFont()->getColor()->setRGB('000000');



        //Write cells
        for ($i=$i+1; $i< $ultimaLinha+3; $i++){

            $formulaAC = "=SUM(".'B'.$i.':H'.$i.")";
            $formulaAC2 = "=SUM(".'M'.$i.':S'.$i.")";
            $formulaNICR = "=((I".($i)." * J".($i).")/10)+K".($i);
            $formulaNICR2 = "=((T".($i)." * U".($i).")/10)+V".($i);

            $planilhaCartas
                ->setCellValue('A'.($i), "='Candidato'!A".($i))
                ->setCellValue('I'.($i), $formulaAC)
                ->setCellValue('L'.($i), $formulaNICR)
                ->setCellValue('T'.($i), $formulaAC2)
                ->setCellValue('W'.($i), $formulaNICR2)
                ->setCellValue('X'.($i), '=(L'.($i).' + W'.($i).')');
        }


        $qtd_linhas = $planilhaCartas->getHighestRow();

        for ($k=1; $k<=$qtd_linhas; $k++){
            $planilhaCartas->getRowDimension(''.$k.'')->setRowHeight(20);
        }

        $planilhaCartas->getRowDimension($linhaSegundoHeader)->setRowHeight(40);
        $planilhaCartas->getRowDimension(2)->setRowHeight(40);

        $planilhaCartas->setTitle("Cartas");


    }

    public function planilhaMediaFinalFormatacao($planilhaMediaFinal,$intervalo_tamanho){


        //define a página como formato em RETRATO

        $planilhaMediaFinal->getPageSetup()
            ->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        //MESCLAGEM DE CELULAS
        $planilhaMediaFinal->mergeCells("A1:E1");

        //INSERE NEGRITO
        $planilhaMediaFinal->getStyle("A1:E2")->getFont()->setBold(true);

        //definindo altura da linha do header
        $planilhaMediaFinal->getRowDimension(1)->setRowHeight(20);
        $planilhaMediaFinal->getRowDimension(2)->setRowHeight(40);

        //DEFINE ALINHAMENTO CENTRAL
        $planilhaMediaFinal->getStyle( "A1:K999" )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $planilhaMediaFinal->getStyle( "A1:K999" )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //DEFINE O TAMANHO DAS LARGURAS DAS COLUNAS
        $planilhaMediaFinal->getColumnDimension('A')->setWidth(40);
        $planilhaMediaFinal->getColumnDimension('B')->setWidth(10);
        $planilhaMediaFinal->getColumnDimension('C')->setWidth(10);
        $planilhaMediaFinal->getColumnDimension('D')->setWidth(15);
        $planilhaMediaFinal->getColumnDimension('E')->setWidth(10);

        //INSERE VALORES NAS COLUNAS
        $planilhaMediaFinal
                ->setCellValue("A1", "Mestrado" )
                ->setCellValue("A2", "Candidato" )
                ->setCellValue("B2", "Prova" )
                ->setCellValue("C2", "Proposta" )
                ->setCellValue("D2", "Títulos + Carta" )
                ->setCellValue("E2", "Média" );

          $BStyle = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $planilhaMediaFinal->getStyle($intervalo_tamanho)->applyFromArray($BStyle);

    }

    public function planilhaMediaFinal($planilhaMediaFinal,$linhaAtual,$ultimaLinha){




        //ESCREVE VALORES NAS CÉLULAS
        for ($i=0; $i< $linhaAtual; $i++){

            $planilhaMediaFinal
                ->setCellValue('A'.($i+3), "='Candidato'!A".($i+3))
                ->setCellValue('B'.($i+3), "='Provas'!C".($i+3))
                ->setCellValue('C'.($i+3), "='Propostas'!E".($i+3))
                ->setCellValue('D'.($i+3), "=AVERAGE('Títulos'!J".($i+4).",Cartas!X".($i+3).")");
          }

          //verificar erro no planilha do Professor !

        $i = $i+4;

        //DEFININDO VALORES PARA AS COLUNAS
        $planilhaMediaFinal
                ->setCellValue("A".($i-1), "Doutorado" )
                ->setCellValue("A".($i), "Candidato" )
                ->setCellValue("B".($i), "Prova" )
                ->setCellValue("C".($i), "Proposta" )
                ->setCellValue("D".($i), "Títulos + Carta" )
                ->setCellValue("E".($i), "Média" );

        //COLOCANDO NEGRITO
        $planilhaMediaFinal->getStyle("A".($i-1).":E".$i)->getFont()->setBold(true);

        //REALIZANDO MESCLAGEM
        $planilhaMediaFinal->mergeCells("A".($i-1).":E".($i-1));

        //definindo altura da linha do header

        $planilhaMediaFinal->getRowDimension($i-1)->setRowHeight(20);
        $planilhaMediaFinal->getRowDimension($i)->setRowHeight(40);

        //definindo a cor de fundo e cor da fonte do título do header: mestrado

        $planilhaMediaFinal
            ->getStyle("A1:C1")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaMediaFinal->getStyle("A1:C1")->getFont()->getColor()->setRGB('FFFFFF');

        //definindo a cor de fundo e cor da fonte do título do header: doutorado


        $planilhaMediaFinal
            ->getStyle("A".($i-1).":C".($i-1))
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF808080');

        $planilhaMediaFinal->getStyle("A".($i-1).":C".($i-1))->getFont()->getColor()->setRGB('FFFFFF');

        $linhaSegundoHeader = $i;


        //INSERINDO VALORES NAS CÉLULAS
        for ($i=$i+1; $i< $ultimaLinha+3; $i++){

            $planilhaMediaFinal
                ->setCellValue('A'.($i), "='Candidato'!A".($i))
                ->setCellValue('B'.($i), "='Provas'!C".($i))
                ->setCellValue('C'.($i), "='Propostas'!E".($i))
                ->setCellValue('D'.($i), "=AVERAGE('Títulos'!J".($i+1).",Cartas!X".($i).")");
          
          //verificar erro no planilha do Professor !



        }

        //DEFINE A ALTURAS DAS CÉLULAS

        $qtd_linhas = $planilhaMediaFinal->getHighestRow();

       for ($k=1; $k<=$qtd_linhas; $k++){
            $planilhaMediaFinal->getRowDimension(''.$k.'')->setRowHeight(20);
        }

        $planilhaMediaFinal->getRowDimension($linhaSegundoHeader)->setRowHeight(40);
        $planilhaMediaFinal->getRowDimension(2)->setRowHeight(40);

        //repetir cabeçalho
        $planilhaMediaFinal->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2,2);


        //DEFININDO O NOME DA PLANILHA
        $planilhaMediaFinal->setTitle("Média Final");


    }
    
   
    public function actionTesteplanilha(){

        $arrayCurso = array(1 => "Mestrado", 2 => "Doutorado");
        $arrayColunas = array(
            0 => "A1", 1 => "A2", 2 => "B2", 3 => "C2", 4 => "D2", 
            5 => "E2", 6 => "F2", 7 => "G2", 8 => "H2", 9 => "I2", 
            10 => "J2", 11 => "K2");

        $linhasPesquisas = ArrayHelper::map(LinhaPesquisa::find()->orderBy('sigla')->all(), 'id', 'sigla');

        $model_candidato_mestrado = Candidato::find()->where("cursodesejado = 1 AND passoatual = 4")->orderBy("nome")->all();
        $model_candidato_doutorado = Candidato::find()->where("cursodesejado = 2 AND passoatual = 4")->orderBy("nome")->all();

        //instanciando objeto Excel

        $objPHPExcel = new \PHPExcel();


        //função responsável pelo Header da planilha

        $intervaloHeader = 'A1:K1';
        $this->planilhaHeaderCandidato($objPHPExcel,$arrayColunas,$arrayCurso[1],$intervaloHeader);

        //parte referente ao mestrado (preenchimento da tabela a partir do banco)

        $i = $this->planilhaCandidatoPreencherDados($objPHPExcel,$model_candidato_mestrado,$linhasPesquisas,$arrayCurso,0,0);

        //fim da parte referente ao mestrado

        //parte referente ao doutorado (preenchimento da tabela a partir do banco)

            $j = $i;

            $objPHPExcel->getActiveSheet()->getRowDimension($j+4)->setRowHeight(40);


            $intervaloHeader = 'A'.($j+3).':K'.($j+3).'';

            $arrayColunas = array(
                0 => "A".($j+3), 1 => "A".($j+4), 2 => "B".($j+4), 3 => "C".($j+4), 4 => "D".($j+4), 
                5 => "E".($j+4), 6 => "F".($j+4), 7 => "G".($j+4), 8 => "H".($j+4), 9 => "I".($j+4), 
                10 => "J".($j+4), 11 => "K".($j+4));
                
            $this->planilhaHeaderCandidato($objPHPExcel,$arrayColunas,$arrayCurso[2],$intervaloHeader);

            $j= $this->planilhaCandidatoPreencherDados($objPHPExcel,$model_candidato_doutorado,$linhasPesquisas,$arrayCurso,$i+2,$j);

        //fim da parte referente ao doutorado


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
        $objPHPExcel->getActiveSheet()->setTitle('Candidato');

        //obtem intervalo referente ao tamanho da tabela (ex.: A1:k10)
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(0)->calculateWorksheetDimension();
        //função responsável pela formatação da planilha
        $this->planilhaCandidatoFormatacao($objPHPExcel,$intervalo_tamanho);

        //define o tamanho das linhas do header da planilha de candidatos
        $objPHPExcel->getActiveSheet()->getRowDimension("2")->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension($i+4)->setRowHeight(40);

        
        //cria planilha de PROVAS
        $planilhaProvas = $objPHPExcel->createSheet(1);
        $this->planilhaProvas($planilhaProvas,$i,$j);
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(1)->calculateWorksheetDimension();
        $this->planilhaProvasFormatacao($planilhaProvas,$intervalo_tamanho);

        //cria planilhas Propostas
        $planilhaPropostas = $objPHPExcel->createSheet(2);
        $this->planilhaPropostas($planilhaPropostas,$i,$j);
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(2)->calculateWorksheetDimension();
        $this->planilhaPropostasFormatacao($planilhaPropostas,$intervalo_tamanho);

        //Cria planilhas de Títulos
        $planilhaTitulos = $objPHPExcel->createSheet(3);
        $this->planilhaTitulos($planilhaTitulos,$i,$j);
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(3)->calculateWorksheetDimension();
        $this->planilhaTitulosFormatacao($planilhaTitulos,$intervalo_tamanho);

        //Cria planilhas de Cartas
        $planilhaCartas = $objPHPExcel->createSheet(4);
        $this->planilhaCartas($planilhaCartas,$i,$j);
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(4)->calculateWorksheetDimension();
        $this->planilhaCartasFormatacao($planilhaCartas,$intervalo_tamanho);

        //Cria planilhas de Cartas
        $planilhaMediaFinal = $objPHPExcel->createSheet(5);
        $this->planilhaMediaFinal($planilhaMediaFinal,$i,$j);
        $intervalo_tamanho = $objPHPExcel->setActiveSheetIndex(5)->calculateWorksheetDimension();
        $this->planilhaMediaFinalFormatacao($planilhaMediaFinal,$intervalo_tamanho);



        // Acessamos o 'Writer' para poder salvar o arquivo
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela

            header('Content-type: application/vnd.ms-excel');

            header('Content-Disposition: attachment; filename="file.xls"');

            $objWriter->save('php://output');
            $objWriter->save('ARQUIVO.xls');

        
        echo "ok";
        
        
    }


    public function actionCadastroppgi(){
        /*if(Yii::$app->session->get('candidato') !== null)
        $this->redirect(['candidato/passo1']);*/
    
        $this->layout = '@app/views/layouts/main-login.php';
        
        $model = new Candidato();  

        if ($model->load(Yii::$app->request->post())){                

            $model->inicio = date("Y-m-d H:i:s");
            $model->passoatual = 0;
            $model->repetirSenha = $model->senha = Yii::$app->security->generatePasswordHash($model->senha);
            $model->status = 10;

            try{
                if(!$model->save()){
                    $this->mensagens('warning', 'Candidato Já Inscrito', 'Candidato Informado Já se Encontra cadastrado para este edital, Efetue o seu Login.');

                    return $this->redirect(['site/login']);
                }else{
                    //setando o id do candidato via sessão
                        $session = Yii::$app->session;
                        $session->open();
                        $session->set('candidato',$model->id);
                    //fim -> setando id do candidato

                    return $this->redirect(['candidato/passo1']);
                }
            }catch(\Exception $e){ 
                $this->mensagens('danger', 'Erro ao salvar candidato', 'Verifique os campos e tente novamente');
                throw new \yii\web\HttpException(405, 'Erro com relação ao identificador do edital'); 
            }
        }

        $edital = new Edital();
        $edital = $edital->getEditaisDisponiveis();

        return $this->render('/candidato/create0', [
            'model' => $model,
            'edital' => $edital,
        ]);
    }

    public function actionLogin()
    {

        /*Redirecionamento para o formulário caso candidato esteja "logado"*/
        
        /*if(Yii::$app->session->get('candidato') !== null)
            $this->redirect(['candidato/passo1']);*/


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()){

            //setando o id do candidato via sessão
            $session = Yii::$app->session;
            $session->open();
            $session->set('candidato', Yii::$app->user->identity->id);
            //fim -> setando id do candidato
            $this->redirect(['candidato/passo1']);
        }else{

        $edital = new Edital();
        $edital = $edital->getEditaisDisponiveis();
            
            return $this->render('login', [
                'model' => $model,
                'edital' => $edital,

            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->session->destroy();

        return $this->goHome();
    }

    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $this->mensagens('success', 'Email Enviado com Sucesso.', 'Verifique sua conta de email');

                return $this->goHome();
            } else {
                $this->mensagens('warning', 'Erro ao Enviar Email', 'Desculpe, o email não pode ser enviado. Verique sua conexão ou contate o administrador');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
        /* Envio de mensagens para views
       Tipo: success, danger, warning*/
    protected function mensagens($tipo, $titulo, $mensagem){
        Yii::$app->session->setFlash($tipo, [
            'type' => $tipo,
            'icon' => 'home',
            'duration' => 5000,
            'message' => $mensagem,
            'title' => $titulo,
            'positonY' => 'top',
            'positonX' => 'center',
            'showProgressbar' => true,
        ]);
    }
}
