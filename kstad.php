<?php

/*
 * Template Name: COSIE
 * Version: 1
 * Description: A certificate for COSIE
 * Author: Tom Woodward
 * Author URI: https://tomwoodward.us
 * Group: Core
 * License: GPLv2
 * Required PDF Version: 4.0-alpha
 * Tags: Header, Footer, Background, Optional HTML Fields, Optional Page Fields, Field Border Color
 */


/* Prevent direct access to the template (always good to include this) */
if ( ! class_exists( 'GFForms' ) ) {
	return;
}

/**
 * All Gravity PDF v4/v5/v6 templates have access to the following variables:
 *
 * @var array  $form      The current Gravity Form array
 * @var array  $entry     The raw entry data
 * @var array  $form_data The processed entry data stored in an array
 * @var object $settings  The current PDF configuration
 * @var array  $fields    An array of Gravity Form fields which can be accessed with their ID number
 * @var array  $config    The initialised template config class – eg. /config/zadani.php
 */

?>

<!-- Any PDF CSS styles can be placed in the style tag below -->
<style>
	  @page {
        footer: html_myFooter;
        header: html_myHeader;
    }

	h1 {
		text-align: left;
		border-bottom: 1px solid #ea9a4d;
		margin-top: 20px;
	}

	h2 {
		font-size: 1.1em;
		border-bottom: 1px solid #cdd62b;
	}
	.footer {
		width: 100%;
	}

	td{
		padding: 10px;
		font-size: .6em;
	}

	.left-img {
		display: inline-block;
		float: left;
	}
	.cert {
		font-size: 1.2em;
		font-weight: 700;
		text-align: center;
		line-height: 40px;
	}

	.large {
		font-size: 1.8em;
		text-align: center;
		line-height: 1em;
	}

	.medium {
		text-align: center;
		font-weight: 800;
		font-size: 1.2em;
	}
	.header-wrapper {
		padding-bottom: 20px;
	}

	.left-foot {
		width: 150px;
	}

	.mid-foot {
		width: 250px;
	}

	
</style>

<htmlpageheader name="myHeader">
	<div class="header-wrapper">
		<img src="https://sola.kau.se/cosie/wp-content/uploads/sites/176/2021/04/cosi_orange.png" width="55px" height="auto" class="left-img">
		<div class="cert">Certificate of completion of the CoSIE-MOOC</div>
	</div>
</htmlpageheader>


<htmlpagefooter name="myFooter">
    <div class="footer">
    	<table>    		
    		<tbody>
    			<tr>
    				<td class="left-foot"><img src="https://sola.kau.se/cosie/wp-content/uploads/sites/176/2021/03/Obligatory-elements-in-CoSIE-communications-Cosie-logo-with-text.jpg" width="150px" height="auto" alt="CoSIE Logo">
    				</td>
    				<td class="mid-foot">
    				The content of the MOOC reflects the participant's views and the Managing Agency cannot be held responsible for any use that may be made of the information it contains</td>
    				<td class="right-foot"><img src="https://sola.kau.se/cosie/wp-content/uploads/sites/176/2021/03/Obligatory-elements-in-CoSIE-communications-EU-flag.jpg" width="220px" height="auto" alt="This project has receiving funding from the European Union's Horizon 2020 research and innovation programme under grant agreement No 770492."></td>
    			</tr>
    		</tbody>
    	</table>
    	{PAGENO}/{nbpg}
    </div>
</htmlpagefooter>


<?php 
$response_1 = $form_data['field'][1];
$response_2 = $form_data['field'][2];
$response_3 = $form_data['field'][3];
$response_4 = $form_data['field'][4];

$first_name = $form_data['field'][5]['first'];
$last_name = $form_data['field'][5]['last'];
$date =  $form_data['date_created'];

?>
<h1>Certificate of Completion</h1>
<p class="large">This certificate acknowledges that</p>
<div class="name large"><?php echo $first_name . ' ' . $last_name ;?></div>
<p class="medium">successfully completed the CoSIE-MOOC (<?php echo $date;?>)</p>

<p>The CoSIE-MOOC correspond to one week of full time study. CoSIE (Co-creation for service innovation in Europe) is a European innovation action and research project funded by the European Union’s research and innovation programme. One of the outputs of this project is the CoSIE-MOOC (Massive Open Online Course) module that summarizes some of the major findings and insights from piloting co-creation initiatives and associated research in a comprehensive and easy understandable way.</p>
<p>
During the implementation of the CoSIE project, the 24 collaboration partners tested and developed a variety of methods for co-creation in the field of public services in 10 European countries. By testing and experimenting in co-creation the project aimed at improving the inclusion of citizens supported by a service and to promote their possibilities to act as active members of the society. A particular focus in the project has been to engage individuals supported by services especially from so-called ‘hard to reach’ people, in the co-creative design of public services with the aim to better address the outspoken needs.</p>
<p>
During the course, students of the CoSIE-MOOC complete four reflective sessions related to different co-creation aspects based on the overall project insights and case data.</p>
<ol>
	<li>The first reflection concerns the concept of ‘co-creation’, how it could be understood and defined.</li>
	<li>The second reflection is about exercising ‘co-creation’ in different contexts. Co-creation in public services are highly context dependent. Any student of co-creation need to be aware of contextual as well as more general aspects of co-creation.</li>
	<li>The third reflection concerns different tools and methods that may be utilized for ‘co-creation’ activities. </li>
	<li>Finally, the fourth reflection is about how co-creation inevitably pushes to reflect on enabling approaches, that is ethical and moral aspects.</li>
</ol>

<p>For this certificate, the students are asked to fulfill these reflective exercises, within a frame of 200 to 500 words. To be able to complete the task given, the students have to submit their reflections on all the four topics. The aim is that those interested in the student’s knowledge and reflective abilities on co-creation topic will be able to critically engage with their responses. </p>

<p>For more information, please go to the CoSIE-MOOC web page: <a href="https://sola.kau.se/cosie/">https://sola.kau.se/cosie/</a> or the CoSIE project web page at: <a href="https://cosie.turkuamk.fi/">https://cosie.turkuamk.fi/</a>. </p>

<p>CoSIE-MOOC convener: Dr Magnus Lindh (magnus.lindh@kau.se)</p>
<pagebreak/>


<h2><?php echo get_field('prompt_1_title','options') . ': ' . get_field('prompt_1','options');?> </h2>
<?php echo $response_1?>

<h2><?php echo get_field('prompt_2_title','options') . ': ' . get_field('prompt_2','options');?></h2>
<?php echo $response_2?>

<h2><?php echo get_field('prompt_3_title','options') . ': ' . get_field('prompt_3','options');?></h2>
<?php echo $response_3?>

<h2><?php echo get_field('prompt_4_title','options') . ': ' .  get_field('prompt_4','options');?></h2>
<?php echo $response_4?>
