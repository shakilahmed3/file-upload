@extends('Layout/app')


@section('title', 'File Uploading Start')



@section('content')

    <div class="container" style="margin-top:100px">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="card" style="width: 600px">
                    <div class="card-body p-4">
                        <h1 class="card-title text-center">Start First File Upload</h1>
                        <hr>
                        <input id="myFile" class="form-control my-3" type="file">
                        <button onclick="onUpload()" id="uploadBtn" class="btn btn-secondary btn-block my-3">Upload File</button>
                        <h3 class="text-center" id="uploadPercent"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top:70px">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
               <div class="card" style="width: 600px">
                   <div class="card-body p-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody class="tableData">

                        </tbody>
                    </table>
                   </div>
               </div>
            </div>
        </div>
    </div>
@endsection

@section('script')


<script type="text/javascript">


// getFileList();

// function getFileList(){

//     axios.get('/getFile').then(function(response){
//         var JSONDATA = response.data;
//         $.each(JSONDATA, function(i){
//             $('<tr>').html(
//                 `<td>${JSONDATA[i].id}</td>
//                 <td><button data-path="${JSONDATA[i].filePath}" class="btn btn-secondary downloadBtn">Download</button></td>`
//                 ).appendTo('.tableData');

//         })
//         .catch(function(error){

//         })
//     }

// }



getFileList();
        function getFileList(){
            axios.get('/getFile').then(function (response) {
              var JSONDATA=  response.data;
              $.each(JSONDATA,function (i) {
                  $('<tr>').html(
                      "<td>"+JSONDATA[i].id+"</td> " +
                      "<td><a href='/fileDownload/"+JSONDATA[i].filePath+"'class='btn  btn-secondary btn-block' >Download</button></td>"
                  ).appendTo('.tableData');
              })
            }).catch(function (error) {
            })
        }


    function onUpload(){
        let myFile = document.getElementById("myFile").files[0];
        let fileName = myFile.name;
        let fileSize = myFile.size;
        let fileFormat = fileName.split('.').pop();

        let fileData = new FormData();
        fileData.append('fileKey',myFile);


        let config = {
            headers:{'content-type':'multipart/form-data'},
            onUploadProgress:function(ProgressEvent){
                let percentComplted = Math.round((ProgressEvent.loaded * 100)/ProgressEvent.total);
                let uploadedMB = ProgressEvent.loaded / (1028*1028);
                let totalMB =  ProgressEvent.total / (1028*1028);
                let leftMb = totalMB - uploadedMB;
                $("#uploadPercent").html("Uploaded: "+uploadedMB.toFixed(2)+"MB   Due "+leftMb.toFixed(2)+"MB");
            }

        }

        let url = '/fileUp';

        axios.post(url,fileData,config)
        .then((response)=>{
            console.log(response);

            if(response.status==200){
                $("#uploadPercent").html("Upload Success");

                setTimeout(()=>{
                 $("#uploadPercent").html(" ");
                },2000)

            }else{
                $("#uploadPercent").html("Upload Failed");
                setTimeout(()=>{
                 $("#uploadPercent").html(" ");
                },2000)
            }

        }).catch((error)=>{
            $("#uploadPercent").html("Upload Failed");

            setTimeout(()=>{
                 $("#uploadPercent").html(" ");
                },2000)

        })

        // alert(myFile+" "+fileName+" "+fileSize+" "+fileFormat);
    }

</script>
@endsection


