<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API laravel</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!--Personal Information-->
                <div>
                    <div>
                        <h2 id="student-name">Loading...</h2>
                        <strong id="student-number">Student ID: --</strong>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>System ID:</strong>
                                <span id="student-id">--</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Age:</strong>
                                <span id="student-age">--</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Gender:</strong>
                                <span id="student-gender">--</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Address:</strong>
                                <span id="student-address">--</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <span id="student-email">--</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Contact No.:</strong>
                                <span id="student-contact">--</span>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <br>

                <!--Academic Information-->
                <div>
                    <div>
                        <h5>Academic Enrollment</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Course:</strong> <span id="course">--</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Year & Section:</strong> <span><span id="year-level">--</span> <span id="section">--</span></span>
                            </div>
                            <div class="col-sm-6">
                                <strong>School Year:</strong> <span><span id="school-year">--</span> (<span id="semester">--</span>)</span>
                            </div>
                            <div class="col-sm-6">
                                <strong>Status:</strong> <span id="status">--</span>
                            </div>
                        </div>
                    </div>
                </div>
<br>
<br>
<br>
                <!-- Grades Table -->
                <div>
                    <div>
                        <h5>Student Grades</h5>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Subject</th>
                                        <th>Units</th>
                                        <th>Prelim</th>
                                        <th>Midterm</th>
                                        <th>Final</th>
                                        <th>Average</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody id="grades-table-body">
                                    <tr>
                                        <td colspan="8">Loading grades...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


<br>
<br>
<br>

                <!--Academic Summary & Financial Info -->
                <div>
                    <div>
                        <h5>Summary & Financials</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>General Average:</strong> <span id="gen-avg">--</span></p>
                                <p><strong>Total Units:</strong> <span id="total-units">--</span></p>
                                <p><strong>Academic Status:</strong> <span id="acad-status">--</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Outstanding Balance:</strong> <span id="balance">--</span></p>
                                <p><strong>Payment Status:</strong> <span id="pay-status">--</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $.ajax({
            url: '/proxy',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Personal Info
                    if (response.student) {
                        const student = response.student;
                        const fullName = `${student.first_name} ${student.middle_name} ${student.last_name}`;
                        $('#student-name').text(fullName);
                        $('#student-number').text(`Student ID: ${student.student_number}`);
                        $('#student-id').text(student.id);
                        $('#student-age').text(student.age);
                        $('#student-gender').text(student.gender);
                        $('#student-address').text(student.address);
                        $('#student-email').attr('href', `mailto:${student.email}`).text(student.email);
                        $('#student-contact').attr('href', `tel:${student.contact_number}`).text(student.contact_number);
                    }

                    // Academic Information
                    if (response.academic_information) {
                        const acad = response.academic_information;
                        $('#course').text(acad.course);
                        $('#year-level').text(acad.year_level);
                        $('#section').text(acad.section);
                        $('#school-year').text(acad.school_year);
                        $('#semester').text(acad.semester);
                        $('#status').text(acad.status);
                    }

                    // Grades 
                    if (response.grades && Array.isArray(response.grades)) {
                        const rows = response.grades.map(g => `
                            <tr>
                                <td><strong>${g.subject_code}</strong></td>
                                <td>${g.subject_name}</td>
                                <td>${g.units}</td>
                                <td>${g.prelim}</td>
                                <td>${g.midterm}</td>
                                <td>${g.final}</td>
                                <td>${g.average}</td>
                                <td>
                                    <span>
                                        ${g.remarks}
                                    </span>
                                </td>
                            </tr>
                        `).join('');
                        
                        $('#grades-table-body').html(rows);
                    } else {
                        $('#grades-table-body').html('<tr><td colspan="8">No grades found.</td></tr>');
                    }

                    // Academic Summary
                    if (response.academic_summary) {
                        $('#gen-avg').text(response.academic_summary.general_average);
                        $('#total-units').text(response.academic_summary.total_units);
                        $('#acad-status').text(response.academic_summary.academic_status);
                    }

                    // Financial Information
                    if (response.financial_information) {
                        const fin = response.financial_information;
                        $('#balance').text(`${fin.currency} ${fin.outstanding_balance.toLocaleString()}`);
                        $('#pay-status').text(fin.payment_status);
                    }

                } else {
                    console.log("API returned success: false");
                    $('#student-name').text("Profile not found");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(`Error fetching data: ${textStatus}, ${errorThrown}`);
                $('#student-name').text("Failed to load profile");
            }
        });
    });
    </script>
</body>
</html>