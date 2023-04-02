<div class="card">
	<div class="card-header">
		<div class="card-tool"> 
			<h5><a href="/movies"><i class="fa fa-home"></i> </a>
			 / <a href="/movies/<?php echo strtolower($server);?>"><?php echo $server;?></a> / Index
			</h5>
		</div>
	</div>

	<div class="card-body">
		<table class="table table-sm">
			<thead>
				<tr>
					<th style="width: 3%">#</th>
					<th style="width: 20%">Picture</th>
					<th>About</th>
					<th style="width: 10%">Host</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if ($results){  
					$i = 1; 
					foreach ($results['title'] as $key=>$val){
						$link = '/movies/watch/'.$server.'/'.SafeEncryption::encrypt($results['url'][$key]. 'play/?ep=2&sv=1');
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td>
								<div class="img-thumbnail">
									<img class="responsive thumbnail" src="<?php echo $results['image'][$key];?>" width="127" />
								</div>
							</td>
							<td>
								<ul class="list-unstyled">
									<li class="list-item"><?php echo $this->Html->link($val,$link);?></li>
									<li class="list-item">Rate: <?php echo $results['rating'][$key];?></li>
									<li class="list-item">Duration: <?php echo $results['durasi'][$key];?></li>
									<li class="list-item">Quality: <?php echo $results['quality'][$key];?></li>
								</ul>  
							</td>
							<td><?php echo $server;?></td>
						</tr>
						<?php 
						$i++; 
					} 
				}
				else {
					?>
					<tr>
						<td colspan="4">... resulting nothing</td>
					</tr>

					<?php 
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="card-footer"> 
			<nav class="col-12" aria-label="Page navigation">
				<ul class="pagination pagination-sm">
					<?php  
						$found = strstr($this->request->here(), '?page');
						$url   = str_replace($found, '', $this->request->here());

						if ($page <= 1){
							?>
							<li class="page-item">
								<a class="page-link text-secondary" href="#"> PREV </a>
							</li> 
							<?php 
						}
						else { ?>
							<li class="page-item">
								<a class="page-link text-primary" href="<?php echo $url;?>?page=<?php echo intval($page)-1;?>"> PREV </a>
							</li> 
							<?php 
						}

						?>
						<li class="page-item"> &nbsp;</li>
						<li class="page-item">
							<a class="page-link text-primary" href="<?php echo $url;?>?page=<?php echo intval($page)+1;?>">NEXT</a>
						</li> 
				</ul>
			</nav> 
	</div>

	<div class="card-footer"> 
		<small>Disclaimer: Tidak satu file pun tersimpan di server ini</small>
	</div>
</div>
