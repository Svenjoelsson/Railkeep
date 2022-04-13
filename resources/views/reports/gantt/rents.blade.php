@extends('layouts.app')

<style>

    .rotate {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
    }
    .year {
        font-weight: bold;
    }

    .wrapper {
    position: relative;
    overflow: auto;
    white-space: nowrap;
    }

    .sticky-col {
    position: -webkit-sticky;
    position: sticky;
    background-color: white;
    }

    .first-col {
    width: 150px;
    min-width: 150px;
    max-width: 150px;
    left: 0px;
    background-color: white !important;
    }

    .second-col {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    left: 150px;
    background-color: white !important;
    }
</style>

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

            <div class="wrapper" >
                <table class="table">
                    <thead>
                        <tr>
                            <td class="sticky-col first-col">Unit</td>
                            <td class="sticky-col second-col">Customer</td>
                            <td class="">Agreement</td>
                            <?php 
                            $cur_year = date('Y');
                            for ($i=0; $i<=10; $i++) {
                                $thisYear = $cur_year++
                                ?>
                                <td class=""><?php echo $thisYear; ?></td>

                                <?php

                                for($iM =1;$iM<=12;$iM++){
                                    $underline = '';
                                    if (date('M') == date("M", strtotime("$iM/12/10")) && date('Y') == $thisYear) {
                                        $underline = 'text-decoration: underline; font-weight: bold;';
                                    }   
                                    echo '<td class="" style="'.$underline.'">';
                                    echo date("M", strtotime("$iM/12/10"));
                                    echo '</td>';
                                }  
                            ?>
                            
                            <?php } ?>
                        </tr>
                        <tbody>
                            <?php 
                                foreach ($rents as $val) {
                                    echo "<tr";
                                    if ($val["status"] == "Reserved") {
                                        echo " style='color:red;'"; // Reserved color
                                    }
                                    echo ">";

                                    echo "<td class='sticky-col first-col'>".$val["unit"]."</td>";
                                    echo "<td class='sticky-col second-col'>".$val["customer"];
                                        if ($val["rentEnd"] == NULL) {
                                            echo '<br /><small>Tillsvidare</small>';
                                        }
                                    echo "</td>";
                                    if ($val["rentEnd"] == NULL) {
                                        $rentEnd = 'Tillsvidare';
                                    } else {
                                        $rentEnd = $val["rentEnd"];
                                    }
                                    echo "<td class=''>".$val["status"]."<br /><small>".$val["rentStart"]."-".$rentEnd."</small></td>";
                                    $cur_year = date('Y');

                                    for ($i=0; $i<=10; $i++) {
                                        $thisYear = $cur_year++;
                                        echo '<td style="background-color:gray;" class="">'.$thisYear.'</td>';

                                        for($iM =1;$iM<=12;$iM++){
                                            if ($val["rentEnd"] == NULL) {
                                                $val["rentEnd"] = '2040-12-31';
                                            }
                                            $underline = '';
                                            $convertStartDate = date("Y-m", strtotime($val["rentStart"]));
                                            $convertEndDate = date("Y-m", strtotime($val["rentEnd"]));


                                            if ($convertStartDate == date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                $underline = 'background-color:yellow;';
                                            }   
                                            if ($convertEndDate == date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                $underline = 'background-color:yellow;';
                                            }   
                                            if ($convertStartDate <= date("Y-m", strtotime("$iM/12/".$thisYear)) && $convertEndDate >= date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                $underline = 'background-color:#ccc;';
                                            }   
                                            echo '<td style="'.$underline.'">';


                                            if ($convertStartDate == date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                echo $val["rentStart"];
                                            }
                                            if ($convertEndDate == date("Y-m", strtotime("$iM/12/".$thisYear))) {
                                                echo $val["rentEnd"];
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

@endsection

