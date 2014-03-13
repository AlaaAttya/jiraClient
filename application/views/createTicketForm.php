<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    </head>
    <body>
        <div style="padding: 220px;">
            <form role="form" enctype="multipart/form-data" method="POST" action="http://localhost/jiraClient/index.php/Ticket/submit">
                
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="username...">
                </div>
                
                
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="password...">
                </div>
                
                <div class="form-group">
                    <label for="projectUrl">project id</label>
                    <input type="text" name="projectId" class="form-control" id="projectId" placeholder="project id...">
                </div>

                <div class="form-group">
                    <label for="projectName">project name</label>
                    <input type="text" name="projectName" class="form-control" id="projectName" placeholder="project name...">
                </div>

                <div class="form-group">
                    <label for="projectUrl">project url</label>
                    <input type="text" name="projectUrl" class="form-control" id="projectUrl" placeholder="project url...">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">issue description</label>
                    <input type="text" name="issueDesc" class="form-control" id="exampleInputPassword1" placeholder="issue description...">
                </div>

                <div class="form-group">
                    <label for="issueSummary">issue summary</label>
                    <input type="text" name="issueSummary" class="form-control" id="issueSummary" placeholder="issue summary...">
                </div>

                
                <div class="form-group">
                    <label for="assigneeName">asignee name</label>
                    <input type="text" name="assigneeName" class="form-control" id="assigneeName" placeholder="assignee name...">
                </div>


                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" name="upfile" id="exampleInputFile">
                    <p class="help-block">Example block-level help text here.</p>
                </div>
                <!--<div class="checkbox">
                    <label>
                        <input type="checkbox"> Check me out
                    </label>
                </div>-->
                <button name="submitIssue" type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </body>
</html>
