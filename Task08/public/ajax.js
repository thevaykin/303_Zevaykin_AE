/*function changeForm(form){

    if(surname_index!=0 && course_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(course_index!=0 && semester_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(semester_index!=0 && subject_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_,
                semester: semester_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(subject_index!=0 && mark_==""){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_,
                semester: semester_,
                subject: subject_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });                
    }
    if(mark_!=""){
        if(/^\d*$/.test(mark_) && mark_>=0 && mark_<=100)
        {
            $.ajax({
                url: '/newSessionResult.php',
                method: "get",      
                dataType: "html",
                data: {
                    group: group_,
                    surname: surname_,
                    course: course_,
                    semester: semester_,
                    subject: subject_,
                    mark: mark_
                },
                success:function(data) {
                    $('#body').html(data);
                }       
            });
        } 
        else{
            alert("Количество баллов - целое число от 0 до 100");
            form.mark.value = "";
        }   
    }
}*/

function changeMaster(master){
    var master_ = master.options[master.selectedIndex].value;
    $.ajax({
        url: '/schedule.php',
        method: "get",      
        dataType: "html",
        data: {
            master: master_
        },
        success:function(data) {
            $('#body').html(data);
        }
    });
}

function changeGroupSessions(form){
    var group_index = form.group.selectedIndex;
    var group_ = form.group.options[group.selectedIndex].value;
    var student_index = form.student.selectedIndex;
    var student_ = form.student.options[student.selectedIndex].value;
    if(group_index!=0 && student_index==0){
        $.ajax({
            url: '/session_results.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_
            },
            success:function(data) {
                $('#body').html(data);
            }
        });
    }
    if(student_index!=0){
        $.ajax({
            url: '/session_results.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                student: student_
            },
            success:function(data) {
                $('#body').html(data);
            }
        });
    }
}

function sendClear(){
    location.reload();
}