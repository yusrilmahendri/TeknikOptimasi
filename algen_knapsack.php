<?php
   
    //populasi

    //class prameters
    class Parameters{
       const FILE_NAME = "products.txt";
       const COLUMNS = ['item', 'price'];
       const POPULATION_SIZE = 10;
    }
    
   //membuat katalog for read dataset products.txt 
   class Catalogue{

       //proses konversi index from 1 to 0 menjadi item pres yakni dari integer ke string
       function createProductColumn($listOfRawProduct){
            //read kolom dari kedua data set products
            foreach(array_keys($listOfRawProduct) as $listOfRawProductKey){
              $listOfRawProduct[Parameters::COLUMNS[$listOfRawProductKey]] = $listOfRawProduct[$listOfRawProductKey];  
               
                unset($listOfRawProduct[$listOfRawProductKey]); // disimpan kembali ddan dikosongkan lgi
            }
          return $listOfRawProduct;
       }
        
       //call file koleksi item prodak
       function product(){
            $collectionOfListProduct = [];
             
            $raw_data = file(Parameters::FILE_NAME);
            //read perbaris dataset products
            foreach($raw_data as $listOfRawProduct){
                $collectionOfListProduct[] = $this->createProductColumn(explode(" , ", $listOfRawProduct)); 
            }
          return $collectionOfListProduct;
        }
    }
   
    //create class populasi individu
    class Individu{

        function countNumberOfGen(){
            $catalogue = new Catalogue;
            return count($catalogue->product());
        }

        function createRandomIndividu(){
  
            //generate jumlah gen
            for($i = 0; $i <= $this->countNumberOfGen()-1; $i++){
                $ret[] = rand(0, 1);
            }
            return $ret;
        }
    }

   //create populasi awal
   class Population{
       
        function createRandomPopulation(){

            $individu = new Individu;
            for($i = 0; $i <= Parameters::POPULATION_SIZE-1; $i++){
                $ret[] = $individu->createRandomIndividu();
            }
            return $ret;
       }
    }

    //create class fitness for seleksi item
    class Fitness {
        
        function selectingItem($individu){
             
            //seleksi item per individu
             $catalogue = new Catalogue;

             foreach ($individu as $individuKey => $binaryGen) {
                 if($binaryGen === 1){
                     $ret[] = [
                         'selectedKey' => $individuKey,
                         'selectedPrice' => $catalogue->product()[$individuKey]['price']
                     ];
                 }
              }
            return $ret;
        }

        function calculateFitnessValue($individu){
            print_r($this->selectingItem($individu));
            exit();
        }

        function fitnessEvaluation($population){

            $catalogue = new Catalogue;
        
            foreach ($population as $listOfIndividuKey => $listOfIndividu) {
            
                echo 'Individu-'. $listOfIndividuKey. '<br>';
                  
                //mebaca index per individu
                  foreach ($listOfIndividu as $individuKey => $binaryGen) {
                      echo $binaryGen. '&nbsp;&nbsp;';
                        print_r($catalogue->product()[$individuKey]);
                          echo '<br>';
                  }
                $fitnessValue = $this->calculateFitnessValue($listOfIndividu);
              }
        }
    }

   //proses tampil (read) 
    // $katalog = new Catalogue;
    // $katalog->product($parameters);

    $initialPopulation = new Population;
    $population = $initialPopulation->createRandomPopulation();

    //  $initialPopulation = new Population;
    //  $initialPopulation->createRandomPopulation();

    $fitness = new Fitness;
    $fitness->fitnessEvaluation($population);

    // $individu = new Individu();
    // print_r($individu->createRandomIndividu());
    
    //fungsi fitness 
?> 