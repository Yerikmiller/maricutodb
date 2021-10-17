<?php
#########################################
# MaricutoDB
# Copyright (c) | Yorman Maricuto 2018 |
# Github: Yerikmiller
# http://maricuto.website
#
# MaricutoDB | MDB
# Create, Read, Update, Delete (CRUD)
# Create collections of databases like 'firebase system'
# each collection will represent a single json file or a group of them
#########################################

class Write
{
	public static function NavigationNumbers($limit, $Navigation, $PagePosition, $PaginatorName)
	{
		## Navigation Numbers ##
		intval($Navigation);
		$NavigationNumbers = array();
		# se aplica esta condicion en el primer Numero
		# para eliminar 0 y 1 del Navigation
		if ($PagePosition !== $limit){
			$PagePosition = $PagePosition + 1;
		}
		# Se aplica esta condicion en el penultimo numero
		if ($PagePosition - 1 == $limit - 1) {
			$PagePosition = $PagePosition - 1;
		}
		if (empty($PagePosition) || $PagePosition < 2)
		{
			$PagePosition = $PagePosition + 1;
		}
		foreach (range($PagePosition, $limit) as $numero) {
			$NavigationNumbers[] = $numero;
		}
		$NavigationNumbers = array_slice($NavigationNumbers, 0, $Navigation);
		return $NavigationNumbers;

	}
	public static function PaginatorButtons( 
		$limit,
		$PaginatorName,
	 	$Navigation = '5',
	 	$PagePosition,
	 	$Previus = 'Previus',
	 	$Next = 'Next',
	 	$method = 'POST'
	 	)
	{
		$NavigationNumbers = Write::NavigationNumbers($limit, $Navigation,
		$PagePosition, $PaginatorName);
		
		# se para el script si no hay nada
		if ( $NavigationNumbers[0] <= - 1 ){return FALSE;}
		######################
		if (empty($PagePosition) || $PagePosition < 2)
		{
			$ToNextPage = 2;
		} else {
			$ToNextPage = $PagePosition + 1;
		}
		if ($PagePosition > 2)
		{
			$ToPreviusPage = $PagePosition - 1;
		} else{
			$ToPreviusPage = 1;
		}
		$ACTUAL_LINK = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		######################
		# Eliminate Numbers if there are only two
		if (count($NavigationNumbers) == 1){$NavigationNumbers[0] = 1;}
		# Eliminate the number 0 if this appear on page...
		if ($NavigationNumbers[0] == 0){unset($NavigationNumbers[0]);}


		# Si se esta en el punto de inicio deshabilita el previus button
		if (empty($PagePosition) || $PagePosition < 2)
		{
			$DisabledButtonPrevius = 'disabled="TRUE"';
			$DisabledButtonNext = '';
		}
		# Si se esta en un punto medio aparecen ambos botones
		elseif ($PagePosition > 1 && $PagePosition < $limit)
		{
			$DisabledButtonPrevius = '';
			$DisabledButtonNext = '';
		}
		# Si se esta en el limite deshabilita el next button
		elseif ($PagePosition == $limit) {
			$DisabledButtonPrevius = '';
			$DisabledButtonNext = 'disabled="TRUE"';
		}
		if ( $GLOBALS['PerPage'] >= $GLOBALS['CountData'] ){return NULL;}
			

		if($method == 'GET'){$method = 'GET';}else{$method = 'POST';}


		$FormStart = '<form method="'.$method.'" action="http://'.ACTUAL_LINK.'#'.$PaginatorName.'">';
		$PreviusButton = '<button '.$DisabledButtonPrevius.' type="submit" class="MDBButtons" id="MDBprevius" value="'.$ToPreviusPage.'" name="'.$PaginatorName.'">'.$Previus.'</button>';
		$NextButton = '<button '.$DisabledButtonNext.' type="submit" class="MDBButtons" id="MDBNext" value="'.$ToNextPage.'" name="'.$PaginatorName.'">'.$Next.'</button>';
		$FormEnd = '</form>';

		if (empty($PagePosition) || $PagePosition < 2)
		{
			echo $FormStart;
			echo $PreviusButton;
			echo '<button type="submit" class="MDBNumbers MDBCurrent" value="1" name="'.$PaginatorName.'">1</button>';
			foreach ($NavigationNumbers as $Numero) 
			{
				if ( $Numero <= 1 )
				{
					echo '<button type="submit" class="MDBNumbers" value="2" name="'.$PaginatorName.'">2</button>';
					break;
				}
				echo '<button type="submit" class="MDBNumbers" value="'.$Numero.'" name="'.$PaginatorName.'">'.$Numero.'</button>';
			}
			echo $NextButton;
			echo $FormEnd;
		}
		elseif ($PagePosition > 1 && $PagePosition < $limit)
		{
			echo $FormStart;
			echo $PreviusButton;
			echo '<button type="submit" class="MDBNumbers" value="1" name="'.$PaginatorName.'">1</button><span id="MDBMore" >...</span>';
			if (count($NavigationNumbers) > 1)
			{	

				if  ($PagePosition - 1 !== $limit - 2)
				{
					$PreviusNum = reset($NavigationNumbers) - 1;
					echo '<button type="submit" class="MDBNumbers MDBCurrent" value="'.$PreviusNum.'" name="'.$PaginatorName.'">'.$PreviusNum.'</button>';
				}
			}
			foreach ($NavigationNumbers as $Numero) 
			{
				# Penultimo Cuando Es Current
				if ($PagePosition == $limit - 1)
				{
					$Penultimo = TRUE;
					echo '<button type="submit" class="MDBNumbers MDBCurrent" value="'.$Numero.'" name="'.$PaginatorName.'">'.$Numero.'</button>';
					break;
				}
				# último desaparece y se muestra 
				# de otra forma en el echo de abajo
				if ($Numero == $limit){break;}
				echo '<button type="submit" class="MDBNumbers" value="'.$Numero.'" name="'.$PaginatorName.'">'.$Numero.'</button>';
			}
			echo '<span id="MDBMore" >...</span><button type="submit" class="MDBNumbers" value="'.$limit.'" name="'.$PaginatorName.'">'.$limit.'</button>';


			echo $NextButton;
			echo $FormEnd;
		}
		elseif ($PagePosition == $limit) {
			echo $FormStart;
			echo $PreviusButton;
			echo '<button type="submit" class="MDBNumbers" value="1" name="'.$PaginatorName.'">1</button><span id="MDBMore" >...</span>';
			echo '<button type="submit" class="MDBNumbers MDBCurrent" value="'.$limit.'" name="'.$PaginatorName.'">'.$limit.'</button>';			
			echo $NextButton;
			echo $FormEnd;
		}
		# elseif ($PagePosition > $limit){
		# 	header('Location: http://'.dirname(ACTUAL_LINK));
		# }
	}
}

?>