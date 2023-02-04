<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Common extends Model
{
    use HasFactory;

    function get_days_of_this_month(){
        $days   =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $data   =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= '"'.$i.' '.date("M").'"';
        endfor;
        return $data;
    }

    function joined_meeting_this_month_chart_data(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_join_meeting_count($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_join_meeting_count($data){
        return Meeting::whereDate('created_at', $data)->sum('joined');;
    }

    function joined_meeting_this_month_chart_data_team(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_join_meeting_count_team($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_join_meeting_count_team($data){
        return Meeting::where('created_by', Auth::user()->name)->whereDate('created_at', $data)->sum('joined');;
    }

    function joined_meeting_this_month_chart_data_user(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_join_meeting_count_user($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_join_meeting_count_user($data){
        $team_leader = Team::where('user', Auth::user()->name)->first();
        return Meeting::where('created_by', $team_leader->created_by)->whereDate('created_at', $data)->sum('joined');;
    }

    function hosted_meeting_this_month_chart_data(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_host_meeting_count($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_host_meeting_count($data){

        return Meeting::whereDate('created_at', $data)->count();;
    }

    function hosted_meeting_this_month_chart_data_team(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_host_meeting_count_team($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_host_meeting_count_team($data){

        return Meeting::where('created_by', Auth::user()->name)->whereDate('created_at', $data)->count();;
    }

    function hosted_meeting_this_month_chart_data_user(){
        $days       =   cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")) + 1;
        $yearmonth  =   date("Y-m");
        $data       =   "";
        for ($i=1; $i <$days ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            $data .= $this->get_host_meeting_count_user($yearmonth.'-'.$i);
        endfor;
        return $data;
    }

    function get_host_meeting_count_user($data){
        $team_leader = Team::where('user', Auth::user()->name)->first();
        return Meeting::where('created_by', $team_leader->created_by)->whereDate('created_at', $data)->count();;
    }

    function yearly_join_meeting_chart_data(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_join_meeting_count($year.'-'.$i);
        endfor;
        return $data;
    }

    function yearly_host_meeting_chart_data(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_host_meeting_count($year.'-'.$i);
        endfor;
        return $data;
    }

    function yearly_join_meeting_chart_data_team(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_join_meeting_count_team($year.'-'.$i);
        endfor;
        return $data;
    }

    function yearly_host_meeting_chart_data_team(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_host_meeting_count_team($year.'-'.$i);
        endfor;
        return $data;
    }

    function yearly_join_meeting_chart_data_user(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_join_meeting_count_user($year.'-'.$i);
        endfor;
        return $data;
    }

    function yearly_host_meeting_chart_data_user(){
        $year   =    date("Y");
        $data   =   "";
        for ($i=1; $i <13 ; $i++):
            if($i !=1):
                $data .= ',';
            endif;
            if($i <10):
                $i = '0'.$i;
            endif;
            $data .= $this->get_host_meeting_count_user($year.'-'.$i);
        endfor;
        return $data;
    }
}
