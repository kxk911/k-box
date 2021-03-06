@extends('widgets.widget-layout')

<?php
/**
 * Parameters:
 *
 * results_found: number, the number of results found
 * search_time: number, the time spent for searching
 * document_total: number, the total available documents in K-Link
 *
 */
?>

@section('widget_class')
search-statistics
@stop

@section('widget_content')

	<p> 
		<span class="found">{{ $results_found }}</span><span class="total"> / {{$document_total}}</span> {{ trans_choice('widgets.search_statistics.found', $results_found) }}
	</p>

	<div class="meter">
		<div class="bar" @if($document_total > 0) style="width:{{round($results_found/$document_total*100) }}% "@endif></div>
	</div>

@stop
