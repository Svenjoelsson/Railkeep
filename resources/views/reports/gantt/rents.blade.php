@extends('layouts.app')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gantt</h1>
                    Rental gantt schedule
                </div>
            </div>
        </div>
    </section>

    <div class="view" style="background-color:#f4f6fa; height:auto;">

            <div class="ganttWrapper">
                <table class="table" id="gantt">
                    <thead>
                        <tr>
                            <td class="sticky-col first-col">Unit</td>
                            <?php 
                            $cur_year = date('Y');
                            for ($i=0; $i<=10; $i++) {
                                $thisYear = $cur_year++
                                ?>
                                <td class="year"><?php echo $thisYear; ?></td>

                                <?php

                                for($iM =1;$iM<=12;$iM++){
                                    $underline = '';
                                    if (date('M') == date("M", strtotime("$iM/12/10")) && date('Y') == $thisYear) {
                                        $underline = 'text-decoration: underline; font-weight: bold;';
                                    }   
                                    echo '<td class="" style="background-color:white;'.$underline.'">';
                                    echo date("M", strtotime("$iM/12/10"));
                                    echo '</td>';
                                }  
                            ?>
                            
                            <?php } ?>
                        </tr>
                        <tbody>
                            
                            <?php 
                                foreach ($rents as $key => $value) {                                    
                                    echo "<td style='font-weight: bold;' class='sticky-col first-col'>".$key."</td>";
                                    
                                    $cur_year = date('Y');
                                    for ($i=0; $i<=10; $i++) {
                                        $thisYear = $cur_year++;
                                        
                                        echo '<td class="year">'.$thisYear.'</td>';
                                        for($iM = 1; $iM <=12; $iM++){ 
                                            echo '<td class="cell '.$key."-".$thisYear."-".$iM.'">';
                                            foreach ($value as $val) {
                                                $style = '';
                                                $convertStartDate = date("Y-m", strtotime($val["rentStart"]));
                                                $convertEndDate = date("Y-m", strtotime($val["rentEnd"]));
                                                
                                                if ($convertStartDate <= date("Y-m", strtotime("$iM/12/".$thisYear)) && $convertEndDate >= date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                   echo "<span data-toggle='tooltip' title='".$val["rentStart"]." - ".$val["rentEnd"]."'>".$val["customer"]."</span>";                                                    
                                                }   
                                            }   
                                            echo '</td>';
                                        }
                                    }
                                    echo "</tr>";
                                }
                            ?>

                        </tbody>
                    </thead>
                    
                </table>

                
            </div>
    </div>

<script>


</script>

@endsection

