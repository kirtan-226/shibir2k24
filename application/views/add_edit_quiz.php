<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding-top: 20px;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
    }
    .question {
      font-weight: bold;
      margin-bottom: 20px;
    }
    .options {
      padding-left: 20px;
    }
    .btn-primary {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Quiz Admin Panel</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add Question</button>
    <hr>
    <div id="questions">

    <?php if(isset($questions) && !empty($questions)){?>
        <?php foreach($questions as $question){?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['quiz']?></h5>
                    <h5 class="card-title">Question : <?php echo $question['question']?></h5>
                    <p class="card-text">a)<?php echo $question['option_1']?></p>
                    <p class="card-text">b)<?php echo $question['option_2']?></p>
                    <p class="card-text">c)<?php echo $question['option_3']?></p>
                    <p class="card-text">d)<?php echo $question['option_4']?></p>
                    <p class="card-text">Correct Answer: <?php echo $question['correct_answer']?></p>
                    <!-- Edit and Delete buttons -->
                    <div class="btn-group" role="group" aria-label="Question Actions">
                    <button type="button" class="btn btn-primary edit-question" data-question-id="<?php echo $question['id']; ?>">Edit</button>
                    <button type="button" class="btn btn-danger delete-question" data-question-id="<?php echo $question['id']; ?>" style="margin-top: 10px;">Delete</button>
                    </div>
                </div>
            </div>
        <?php }?>
    <?php }?>
</div>

  </div>

  <!-- Add Question Modal -->
  <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionModalLabel">Add Question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addQuestionForm">
          <input type="hidden" id="questionId" name="questionId"> <!-- Hidden field to store the question ID -->
            <div class="mb-3">
                <label for="quiz" class="form-label">Quiz</label>
                <select class="form-select" id="quiz" required>
                    <option value="">Select an option</option>
                    <option value="bharuch">Bharuch</option>
                    <option value="ellora">Ellora</option>
                    <option value="shibir_session_1">Shibir session 1</option>
                    <option value="shibir_session_2">Shibir session 2</option>
                    <option value="shibir_session_3">Shibir session 3</option>
                    <option value="shibir_session_4">Shibir session 4</option>
                    <option value="pune">Pune</option>
                    <option value="imagica">Imagica</option>
                    <option value="tithal">Tithal</option>
                    <option value="navsari">Navsari</option>
                </select>
            </div>

            <div class="mb-3">
              <label for="question" class="form-label">Question</label>
              <input type="text" class="form-control" id="question" required>
            </div>
            <div class="mb-3">
              <label for="option1" class="form-label">Option 1</label>
              <input type="text" class="form-control" id="option1" required>
            </div>
            <div class="mb-3">
              <label for="option2" class="form-label">Option 2</label>
              <input type="text" class="form-control" id="option2" required>
            </div>
            <div class="mb-3">
              <label for="option3" class="form-label">Option 3</label>
              <input type="text" class="form-control" id="option3" >
            </div>
            <div class="mb-3">
              <label for="option4" class="form-label">Option 4</label>
              <input type="text" class="form-control" id="option4" >
            </div>
            <div class="mb-3">
              <label for="correctAnswer" class="form-label">Correct Answer (e.g., 1, 2, 3, 4)</label>
              <input type="text" class="form-control" id="correctAnswer" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    let questionCount = 0;

      jQuery(document).ready(function($) {
        $('.edit-question').click(function() {
        var questionId = $(this).data('question-id');
        $.ajax({
            url: 'get_question/' + questionId,
            type: 'GET',
            success: function(response) {
                    // Assuming response is JSON data containing the question details
                var question = JSON.parse(response);
                console.log('Question:', question); // Debugging statement
                $('#questionId').val(questionId); // Set the questionId in the hidden field
                $('#quiz').val(question.quiz);
                $('#question').val(question.question);
                $('#option1').val(question.option_1);
                $('#option2').val(question.option_2);
                $('#option3').val(question.option_3);
                $('#option4').val(question.option_4);
                $('#correctAnswer').val(question.correct_answer);
                $('#addQuestionModal').modal('show');
            }
        });
    });
    $('.delete-question').click(function() {
        var questionId = $(this).data('question-id');
        if (confirm('Are you sure you want to delete this question?')) {
            $.ajax({
                url: 'delete_question/' + questionId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    location.reload();
                }
            });
        }
    });

    // Add or Edit Question Form
    $('#addQuestionForm').submit(function(event) {
        event.preventDefault();
        var form = $(this);
        var questionId = $('#questionId').val() ?? '';
        var quiz = $('#quiz').val();
        var question = $('#question').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();
        var option3 = $('#option3').val();
        var option4 = $('#option4').val();
        var correctAnswer = $('#correctAnswer').val();

        // Disable the form to prevent multiple submissions
        form.find('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: 'add_edit_quiz',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                question_id: questionId,
                quiz: quiz,
                question: question,
                option_1: option1,
                option_2: option2,
                option_3: option3,
                option_4: option4,
                correct_answer: correctAnswer
            }),
            success: function(response) {
                console.log(response);
                location.reload();
                $('#addQuestionModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            },
            complete: function() {
                // Re-enable the form after the request is completed
                form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });
});

  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>