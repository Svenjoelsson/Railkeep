<div>
   
    <div class="panel panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
   
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                {{ $message }}
        </div>
        @endif
  
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal" data-target="#exampleModal">
    Upload
</button><br /><br />
        

      </div>

    </div>
</div><br />
        <table class="table table-hover">
            <tbody>
        <?php 

        $buildPath = Request::segment(1)."/".Request::segment(2);
        $path = public_path('uploads/'.$buildPath);
        
        if (is_dir($path)) {
            $files = scandir($path);
            function scan_dir($dir) {
                $ignored = array('.', '..', '.svn', '.htaccess');

                $files = array();    
                foreach (scandir($dir) as $file) {
                    if (in_array($file, $ignored)) continue;
                    $files[$file] = filemtime($dir . '/' . $file);
                }

                arsort($files);
                $files = array_keys($files);

                return ($files) ? $files : false;
            }
            if (scan_dir($path)) {
              
              foreach (scan_dir($path) as $val) {
                  echo "<tr>";
                  if ($val !== '.' && $val !== '..') {
                      if (str_contains($val, '.pdf')) {
                          echo "<td><img src='https://cdn-icons-png.flaticon.com/512/7271/7271042.png' height='50'/></td>";  
                      }
                      else if (str_contains($val, '.xlsx')) {
                          echo "<td><img src='https://cdn-icons-png.flaticon.com/512/7271/7271067.png' height='50'/></td>";  
                      }
                      else if (str_contains($val, '.docx')) {
                          echo "<td><img src='https://cdn-icons-png.flaticon.com/512/7271/7271015.png' height='50'/></td>";  
                      }
                      else {
                          echo "<td><img style='border: 2px solid #000;' src='/uploads/".Request::segment(1)."/".Request::segment(2)."/".$val."' height='50'/></td>";  
                      }
                      echo "<td style='vertical-align: middle;'><a href='#' class='fileprev' data-file='/uploads/".Request::segment(1)."/".Request::segment(2)."/".$val."' data-toggle='modal' data-target='#preview' >".$val."</a></td>";
                      echo "<td><div class='btn-group'><a class='btn btn-default btn-xs' href='/file-upload/download/".Request::segment(1)."/".Request::segment(2)."/".$val."'><i class='fa fa-download'></i></a><a class='btn btn-danger btn-xs' href='/file-upload/delete/".Request::segment(1)."/".Request::segment(2)."/".$val."'><i class='fa fa-trash'></i></a></div></td>";
                      echo "</tr>";
                  }
              }
            } 
        }

      ?>

      </tbody>
      </table>



      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">File upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
          <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="firstUrl" value="{!! Request::segment(1) !!}">
                <input type="hidden" name="secondUrl" value="{!! Request::segment(2) !!}">
                @csrf
                <div class="row">
      
                    <div class="col-md-12">
                        <div class="custom-file">
                          <center><b>Drag & Drop</b>
                          <div class="upload-container">
                            <input type="file" name="file" id="file_upload" />
                          </div>
                            <!--<input type="file" name="file" class="custom-file-input" id="customFile file_upload">
                            <label class="custom-file-label" for="customFile">Choose file</label>-->
                            <br />
                        </div>
                        
                    </div>
                    
       
                </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Preview file</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 0;">
            <iframe id="myIframe" width="100%" height="100%" src=""></iframe>
            
        </div>
      </div>
    </div>
  </div>


<script>
    var elements = document.getElementsByClassName("fileprev");

    var myFunction = function() {
        var attribute = this.getAttribute("data-file");
        console.log(attribute);
        document.getElementById('myIframe').src = attribute;
    };
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', myFunction, false);
    }
    
</script>