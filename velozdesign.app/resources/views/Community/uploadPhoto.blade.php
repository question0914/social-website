<div className="container">
    <div className="modal fade" id="upload">
        <div className="modal-dialog">
            <div className="modal-content">
                <form id="form" encType="multipart/form-data" role="form">
                    <div className="modal-header">
                        <button type="button" className="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span className="sr-only">Close</span></button>
                        <h4 className="modal-title">Upload Image</h4>
                    </div>
                    <div className="modal-body">
                        <div className="imageupload panel panel-default">
                            <div className="panel-heading clearfix">
                                <h3 className="panel-title pull-left">Choose a file or enter a URL</h3>
                                <div className="btn-group pull-right">
                                    <button type="button" className="btn btn-default active">File</button>
                                    <button type="button" className="btn btn-default">URL</button>
                                </div>
                            </div>
                            <div className="file-tab panel-body">
                                <label className="btn btn-default btn-file">
                                    <span>Browse</span>
                                    {/*<!-- The file is stored here. -->*/}
                                    <input type="file" name="upload_file"></input>
                                </label>
                                <button type="button" className="btn btn-default">Remove</button>
                                <div className="modal-footer">
                                    <button type="button" className="btn btn-primary">Upload</button>
                                </div>

                            </div>

                            <div className="url-tab panel-body">
                                <div className="input-group">
                                    <input type="text" className="form-control hasclear" placeholder="Image URL"></input>
                                        <div className="input-group-btn">
                                            <button type="button" className="btn btn-default">Submit</button>
                                        </div>
                                </div>
                                <button type="button" className="btn btn-default">Remove</button>
                                <button type="button" className="btn btn-primary">Upload</button>

                                {/*<!-- The URL is stored here. -->*/}
                                <input type="hidden" name="image-url"></input>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
