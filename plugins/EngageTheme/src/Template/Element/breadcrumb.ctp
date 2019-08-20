<?php
	$explodeBreadcrumb = explode('::', $breadcrumb);
	$total = count($explodeBreadcrumb);
?>
<section class="breadcrumb mt-0 p-0 mb-0">
    <div class="center-content text-center w-100">
        <p class="text-breadcrumb text-center fw600">
			<?php
				$i = 1;
				foreach ($explodeBreadcrumb as $list):
					if ($list == 'Home') {
						$url = $this->Url->build(['_name' => 'home']);
					}
					else {
						$url = '';
					}

					if ($i == 1) {
						echo '<a class="breadcrumb-link" href="' . $url . '">Home</a>'; 
					}
					else {
						$active = '';

						if ($total == $i) {
							echo ' <i class="fa fa-angle-double-right uk-margin-small-right uk-margin-small-left" aria-hidden="true"></i> <span class="active text-pink">' . $list . '</span>';
						}
						else {
							echo ' <i class="fa fa-angle-double-right uk-margin-small-right uk-margin-small-left" aria-hidden="true"></i> ' . $list;
						}
					}

					$i++;
				endforeach;
			?>
		</p>
    </div>
</section>