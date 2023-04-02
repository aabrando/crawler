<div class="card">
	<?php 
	echo $this->Form->create('Host',array(
		'method'	=> 'post'
	));
	?>
	<div class="card-header">
		<div class="card-tool"> 
			<h5><a href="/crawl/movies"><i class="fa fa-home"></i> </a>
			 / <a href="/crawl/host">Host</a>
			 / Edit
			</h5>
		</div>
	</div>

	<div class="card-body">
		<div class="form-group">
			<h4>HOST:</h4>
		</div>
		<?php 
		echo $this->Form->input('id');

		echo $this->Form->input('name',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Name:',
			'placeholder'	=> 'Host name'
		));

		echo $this->Form->input('url',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'URL (No tail forward slash "/"):',
			'placeholder'	=> 'https://11.22.33.44'
		));

		echo $this->Form->input('suffix1',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Suffix for URL',
			'placeholder'	=> '/'
		));

		echo $this->Form->input('index',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Path/query for index page:',
			'placeholder'	=> '/movies/page/'
		));

		echo $this->Form->input('search',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Path/query for search page:',
			'placeholder'	=> '/movies/search/'
		));

		echo $this->Form->input('suffix2',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Suffix URL (additional)',
			'placeholder'	=> 'play/?ep=2&sv=1'
		));

		?>
	</div>
	 
	<div class="card-body">
		<div class="form-group">
			<h4>(INDEX PAGE) DOM Composition for:</h4>
		</div>
		<?php 

		echo $this->Form->input('Dom.1.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Title',
			'placeholder'	=> 'article[class=item] h1 a'
		));

		echo $this->Form->input('Dom.2.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'URL',
			'placeholder'	=> 'article[class=item] h1 a'
		));

		echo $this->Form->input('Dom.3.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Image',
			'placeholder'	=> 'article[class=item] img'
		));

		echo $this->Form->input('Dom.4.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Rating',
			'placeholder'	=> 'article[class=item] div[class=rating]'
		));

		echo $this->Form->input('Dom.5.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Duration',
			'placeholder'	=> 'article[class=item] div[class=dution]'
		));

		echo $this->Form->input('Dom.6.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Quality',
			'placeholder'	=> 'article[class=item] div[class=quality]'
		));

		echo $this->Form->input('Dom.7.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Description',
			'placeholder'	=> 'article[class=item] div[class=desc]'
		));

		?>
	</div>



	<div class="card-body">
		<div class="form-group">
			<h4>(PLAYBACK) DOM Composition for:</h4>
		</div>
		<?php 

		echo $this->Form->input('Dom.9.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Server Playback URL:',
			'placeholder'	=> 'article[class=server] a'
		));

		echo $this->Form->input('Dom.10.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Title:',
			'placeholder'	=> 'article[class=item] h4'
		));

		echo $this->Form->input('Dom.11.dom2find',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Plot/Story:',
			'placeholder'	=> 'article[class=item] p'
		));

		?>
	</div>

	<div class="card-body">
		<div class="form-group">
			<h4>Playback Spescial Prefix Path/query (if any)</h4>
		</div>
		<?php 

		echo $this->Form->input('Playback.path',array(
			'type'		=> 'text',
			'class'		=> 'form-control',
			'div'		=> 'form-group',
			'label'		=> 'Path:',
			'placeholder'	=> '/iembed/?source='
		));

		?>
	</div>

	<div class="card-footer">  
		<div class="form-group">
			<button type="submit" class="btn btn-sm btn-success">Save</button>
			<a href="/crawl/host" class="btn btn-sm btn-primary">Cancel</a>
		</div>
	</div>

	<div class="card-footer"> 
		<small>Disclaimer: Tidak satu file pun tersimpan di server ini</small>
	</div>
	<?php  
		echo $this->Form->end(null);
	?>
</div>
