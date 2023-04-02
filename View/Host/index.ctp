<div class="card">
	<div class="card-header">
		<div class="card-tool"> 
			<h5><a href="/crawl"><i class="fa fa-home"></i> </a>
			 \ <a href="/crawl/movies"> Movies</a>
			 \ Host</a>
			</h5>
		</div>
	</div>

	<div class="card-body">
		<table class="table table-sm">
			<thead>
				<tr>
					<th style="width: 3%">#</th>
					<th style="width: 30%">Nama</th> 
					<th>Url</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if ($hosts){  
					$i = 1; 
					foreach ($hosts as $host){ 
						$link = '/movies/host/'.$host['Host']['name'];
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td>
								<?php echo $this->Html->link($host['Host']['name'], $link) ;?>
							</td>
							<td>
								<?php echo $this->Html->link($host['Host']['url'],$host['Host']['url']); ?>
							</td>
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

	</div>

	<div class="card-footer"> 
		<small>Disclaimer: Tidak satu file pun tersimpan di server ini</small>
	</div>
</div>
