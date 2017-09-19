<?php 
	public function index(){
		$this->load->language('catalog/svgupload');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['entry_upload'] = $this->language->get( 'entry_upload' );
		$this->data['button_upload'] = $this->language->get( 'button_upload' );
		$this->load->model('catalog/svgupload');

		$url = '';

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
						
   		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->data['token'] = $this->session->data['token'];
		 
		$this->template = 'catalog/svgupload.tpl';
		$this->response->setOutput($this->render());

	}
	public function getExtension($str) 
	{
			 $i = strrpos($str,".");
			 if (!$i) { return ""; } 
	
			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
	}
	
				//dhinesh start 23.1
	
	public function upload_to_S3($file,$image_id,$type)
	{
		$this->load->model('catalog/svgupload');
		$last_ids  = $this->model_catalog_svgupload->Next_id();
		$this->log->write('$last_ids : '.$last_ids['auto_increment']);
		$template_id=$last_ids['auto_increment'];
		$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
                    'image/svg+xml',
					'application/x-shockwave-flash'
				);
		
		
		$bucket="uploads.customtobacco.com";
		$site_name = explode('//',HTTP_SERVER);
		$site_basename = explode('.',$site_name[1]);
		
		if (isset($file)) 
		{
	//	$this->log->write('bucket : '.$bucket);
		//$this->log->write('tmp_name : '.$tmp);
		if (!class_exists('S3'))
			require_once ('S3.php');
		if (!defined('awsAccessKey'))
			define('awsAccessKey', 'AKIAJGDA2QKUQS47RM2Q');
		if (!defined('awsSecretKey'))
			define('awsSecretKey', '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');
			$s3 = new S3(awsAccessKey, awsSecretKey);
		//$s3->putObjectFile($tmp, $bucket ,$fileName, S3::ACL_PUBLIC_READ);
		if($type=='svg')
		{
			$lastid=$last_ids['auto_increment']-1;
		}
		else
		{
			$lastid=$last_ids['auto_increment'];
			}
			if($s3->putObjectFile($file, $bucket ,$site_basename[0]."_custom_gallery/template-band-".($lastid), S3::ACL_PUBLIC_READ))
		{
			return 'success';
		}
		else
		{
			return 'Error';
		}
	}
}
		
public function delete_object_s3()
{
	$this->load->model('catalog/svgupload');
	if (!class_exists('S3'))
			require_once ('S3.php');
	
	if (!defined('awsAccessKey'))
			define('awsAccessKey', 'AKIAJGDA2QKUQS47RM2Q');
		if (!defined('awsSecretKey'))
			define('awsSecretKey', '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');
		$bucket="uploads.customtobacco.com";
		
	$s3 = new S3(awsAccessKey, awsSecretKey);
			
	$this->log->write($this->request->post['thumbnail']);
	
	$url=explode('uploads.customtobacco.com',$this->request->post['thumbnail']);	
	$thum=explode('/',$url[1]);
	//$this->log->write('url : '.$thum[2]);
	$image_id=explode('-',end($thum));
	$this->log->write( 'img-id : '.end($image_id));
	if($s3->deleteObject($bucket, $thum[1].'/'.$thum[2]))
	{
		$delete  = $this->model_catalog_svgupload->deletetemplate(end($image_id));
		
	$json['success']='Deleted Successfully';
	}
	else
	{
		$json['error']='Not found';
		}
	$this->response->setOutput(json_encode($json));

	
}
public function ajax()
{
	$this->session->data['band_title']=$this->request->post['band_title'];
	//$this->session->data['upload']['name']=$this->request->files['upload']['name'];
	//$this->session->data['upload']['tmp_name']=$this->request->files['upload']['tmp_name'];
	$this->session->data['upload']=$this->request->files['upload'];
	//$this->session->data['upload']['type']=$this->request->files['upload']['type'];
	//$this->session->data['upload']['error']==$this->request->files['upload']['error'];
/*	
if($this->request->files['upload']['type']=='image/svg+xml')
{
		//$filename = $this->request->files['upload']['name'];
		$filename = $this->request->files['upload']['tmp_name'];
		if(file_exists($filename))
		{
			$json= file_get_contents($filename);
		}
}
else
{*/
	$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
                    'image/svg+xml',
					'application/x-shockwave-flash'
				);
	if (in_array($this->request->files['upload']['type'], $allowed)) 
		{
			if($this->request->files['upload']['size']<(1024*1024))
			{
					$this->load->model('catalog/svgupload');
					$last_ids  = $this->model_catalog_svgupload->Next_id();
					$result=$this->upload_to_S3($this->request->files['upload']['tmp_name'],'template-band-'.$last_ids['auto_increment'],'image');//dhiensh 23.1
					if($result=='success')
					{
					$json='success_image';
					}
					else
					{
						$json='Error';
					}
				
			}
			else
			{
				$json='file too large';
			}
		}
		else
		{
			$json='invalid file type';
			}

//}
$this->response->setOutput($json);
	//$this->log->write('ajax file'.$this->request->files['upload']['tmp_name']);
$this->upload();
}
//dhinesh end 23.1
public function image_write()
{
	//$this->log->write('png  :'.$this->request->post["png"]);
if ($handle = opendir(rtrim(DIR_IMAGE . 'data/admin_upload/')))
 {
    while (false !== ($filename = readdir($handle)))
	 {
		 if(strlen($filename)>3)
		 {
			$tt=$filename;
		 }
     }
    closedir($handle);
}
if (isset($this->request->post["png"]))
{
$imageData=$this->request->post["png"];
$filteredData=substr($imageData, strpos($imageData, ",")+1);
$unencodedData=base64_decode($filteredData);
$fp = fopen( rtrim(DIR_IMAGE . 'data/admin_upload/image.png'), 'wb');
fwrite( $fp, $unencodedData);
fclose( $fp );
}


$this->load->model('catalog/svgupload');
$last_ids  = $this->model_catalog_svgupload->Next_id();
//rename (rtrim(DIR_IMAGE . 'data/admin_upload/10304.png'),rtrim(DIR_IMAGE . 'data/admin_upload/template-band-'.$last_ids['auto_increment'].'.png'));

	$result = $this->upload_to_S3(rtrim(DIR_IMAGE . '../image/data/admin_upload/image.png'),$last_ids['auto_increment'],'svg');//dhiensh 23.1
	
	echo $result;
}

	public function upload()
	{
	$this->load->model('catalog/svgupload');
		$this->load->language('common/filemanager');
		$json = array();
		if (isset($this->session->data['upload']) && ($this->session->data['band_title']!="")) 
		{
			if (isset($this->session->data['upload']) && $this->session->data['upload']['tmp_name'])
			 {
				//$last_ids  = $this->model_catalog_svgupload->getlasttemplateid(); comment by dhiensh 23.1
				$last_ids  = $this->model_catalog_svgupload->Next_id();//dhiensh 23.1
				$filename = basename(html_entity_decode($this->session->data['upload']['name'], ENT_QUOTES, 'UTF-8'));
				$file_extn = explode('.',$filename);
				//$template_name = 'template_'.($last_ids['image_id']+1).'.'.$file_extn[1];
				//$template_name = 'template-band-'.($last_ids['auto_increment']).'.'.$file_extn[1];//dhinesh 23.1
				$template_name = 'template_'.($last_ids['auto_increment']).'.'.$file_extn[1];//dhinesh 23.1
				$thumbnail='template-band-'.($last_ids['auto_increment']);//dhinesh 23.1
				
				if ((strlen($filename) < 3) || (strlen($filename) > 255)) 
				{
					$json['error'] = $this->language->get('error_filename');
				}
				$directory = rtrim(DIR_IMAGE . 'data/band_templates');
				$this->log->write('$directory : '.$directory);
				
				if (!is_dir($directory)) 
				{
					$json['error'] = $this->language->get('error_directory');
				}
				/*if ($this->session->data['upload']['size'] > 300000) {
					$json['error'] = $this->language->get('error_file_size');
				}*/
				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'image/svg+xml',
					'application/x-shockwave-flash'
				);
				if (!in_array($this->session->data['upload']['type'], $allowed)) 
				{
					$json['error'] = $this->language->get('error_file_type');
				}
				$allowed = array(
					'.jpg',
					'.jpeg',
					'.gif',
					'.png',
					'.flv',
					'.svg'
				);
				if (!in_array(strtolower(strrchr($filename, '.')), $allowed))
				{
					$json['error'] = $this->language->get('error_file_type');
				}

				if ($this->session->data['upload']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $this->session->data['upload']['error'];
				}			
			}
			 else
			 {
				$json['error'] = $this->language->get('error_file');
			 }
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		$this->log->write('upload');
		if (!isset($json['error'])) 
		{	
			if (move_uploaded_file($this->request->files['upload']['tmp_name'], $directory . '/' . $template_name))
			 {
				 //$this->model_catalog_svgupload->addtemplate($this->request->files['upload']['name'],'');
				 $site_name = explode('//',HTTP_SERVER);
				 $site_basename = explode('.',$site_name[1]);
			     $this->model_catalog_svgupload->addtemplate($this->request->post['band_title'],'http://uploads.customtobacco.com/'.$site_basename[0]."_custom_gallery/".$thumbnail);

				
			//	$json['success'] = $this->language->get('text_uploaded');
			} else {
				$json['error'] = $this->language->get('error_uploaded');
			}
		}
		//ramya code end
		
//$this->response->setOutput(json_encode($json));
		
	}
	
	
	public function template_list()
	{
		$this->load->model('catalog/svgupload');
		$this->load->language('catalog/svgupload');

		$this->document->setTitle($this->language->get('heading_title_list'));
		
		$this->load->model('catalog/galleryApprove');

		$url = '';

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
						
   		$this->data['heading_title'] = "Template List";
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->data['class_order'] ='desc';
		if(isset($this->request->get['order']))
		{
				if($this->request->get['order']=='desc')
				{
				$this->data['short_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&order=asc', 'SSL');
				$this->data['class_order'] ='desc';
				}
				else 
				{
				$this->data['short_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&order=desc', 'SSL');
				$this->data['class_order'] ='asc';
					}
		}
		else
		{
			$this->data['short_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&order=desc', 'SSL');
			}
			$this->data['class_sort_order'] ='desc';
		if(isset($this->request->get['sort_order']))
		{
				if($this->request->get['sort_order']=='desc')
				{
				$this->data['short_order_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&sort_order=asc', 'SSL');
				$this->data['class_sort_order'] ='desc';
				}
				else 
				{
				$this->data['short_order_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&sort_order=desc', 'SSL');
				$this->data['class_sort_order'] ='asc';
					}
		}
		else
		{
			$this->data['short_order_link'] =$this->url->link('catalog/svgupload/template_list', 'token=' . $this->session->data['token'] . $url.'&sort_order=desc', 'SSL');
			}
		$this->data['token'] = $this->session->data['token'];
		$template_data = array();
		$result = array();
		$templates = $this->model_catalog_svgupload->getTemplates();
			foreach($templates as $template) 
			{
				if($template['image_id']!=9999)//24.3
				{
				if(!$template['blank']){//24.3
				$template_data['image_id'] = $template['image_id'];
				$template_data['title'] = $template['title'];
				$template_data['thumbnail']=$template['thumbnail'];
				$template_data['display_home']=$template['display_home'];
					
				$tagList = $this->model_catalog_svgupload->getTemplateTags($template['image_id']);//24.3
							
				$template_data['tag']= implode(",",$tagList);
				$template_data['no_of_tags']= count($tagList);
				if($template['sort_order'])
				{
				$template_data['sort_order']= $template['sort_order'];
				$template_data['a_sort_order']= $template['sort_order'];
				}
				else
				{
				$template_data['sort_order']= "";
				$template_data['a_sort_order']= "99999";
				}
			    array_push($result,$template_data);
				
				}
				}
			}
			if(isset($this->request->get['order']) && $this->request->get['order']=='desc')
			{
			usort($result, function($a, $b)//added by dhinesh 19.3
					 {  if($a['no_of_tags']==$b['no_of_tags']) return 0;
						  return $a['no_of_tags']<$b['no_of_tags']?1:-1;
				});
			}
			else
			{
				usort($result, function($a, $b)//added by dhinesh 19.3
					 {  if($a['no_of_tags']==$b['no_of_tags']) return 0;
						  return $a['no_of_tags']>$b['no_of_tags']?1:-1;
				});
				}
		if(isset($this->request->get['sort_order']) && $this->request->get['sort_order']=='desc')
			{
			usort($result, function($a, $b)//added by dhinesh 19.3
					 {  if($a['a_sort_order']==$b['a_sort_order'] && $a['a_sort_order']!="") return 0;
						  return $a['a_sort_order']<$b['a_sort_order']?1:-1;
				});
			}
			else
			{
				usort($result, function($a, $b)//added by dhinesh 19.3
					 {  if($a['a_sort_order']==$b['a_sort_order']) return 0;
						  return $a['a_sort_order']>$b['a_sort_order']?1:-1;
				});
				}
		$this->data['templates'] = $result;
		$this->template = 'catalog/template_list.tpl';
		$this->response->setOutput($this->render());
	}
	
/*27.3 start*/
public function update_tags()
{
	$this->log->write($this->request->post['temp_id']);
	$this->log->write($this->request->post['tags']);
	    $temp_id=$this->request->post['temp_id'];
		
		if(isset($this->request->post['tags'])&&!empty($this->request->post['tags']))
			$tag=$this->request->post['tags'];
		else
			$tag="";
		$this->load->model('catalog/svgupload');
	    $this->model_catalog_svgupload->updateTemplateTags($temp_id,$tag);
	}  
		//6.11.2015 start
public function update_home_bands()
{
	$this->log->write($this->request->post['temp_id']);
	$temp_id=$this->request->post['temp_id'];
		
		$this->load->model('catalog/svgupload');
	    $this->model_catalog_svgupload->updatehomeTemplate($temp_id);
	}  	
	public function update_sort_order()
{
	//$this->log->write($this->request->post['temp_id']);
	//$this->log->write($this->request->post['tags']);
	    $temp_id=$this->request->post['temp_id'];
		
		if(isset($this->request->post['sort_order'])&&!empty($this->request->post['sort_order']))
			$sort_order=$this->request->post['sort_order'];
		else
			$sort_order="";
		$this->load->model('catalog/svgupload');
	    $this->model_catalog_svgupload->update_sort_order($temp_id,$sort_order);
	}  
/*27.3 end*/

	public function scratch_list()
	{
		$this->load->model('catalog/svgupload');
		$this->load->language('catalog/svgupload');

		$this->document->setTitle('Scratch List');
		
		$this->load->model('catalog/galleryApprove');

		$url = '';

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Scratch List',
			'href'      => $this->url->link('catalog/svgupload/scratch_list', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
						
   		$this->data['heading_title'] = 'Scratch List';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['token'] = $this->session->data['token'];
		$template_data = array();
		$result = array();
		$templates = $this->model_catalog_svgupload->getTemplates();
			foreach($templates as $template) 
			{
				if($template['image_id']!=9999)//24.3
				{
				if($template['blank'])
				{//24.3
				$template_data['image_id'] = $template['image_id'];
				$template_data['title'] = $template['title'];
				$template_data['thumbnail']=$template['thumbnail'];
			    array_push($result,$template_data);
				
				}
				}
			}
			
		$this->data['templates'] = $result;
		$this->template = 'catalog/scratch_list.tpl';
		$this->response->setOutput($this->render());
	}
?>
