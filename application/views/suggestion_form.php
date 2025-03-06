<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('/Huntm/assets/css/registrationform.css'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <title>Suggestion Form</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif; 
            font-size: 16px; 
            font-weight: 400; 
            color: #333; 
            line-height: 1.6;
            background-color: #2C3E50;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color:#2C3E50; 
            padding: 10px 20px;
            z-index: 1000;
        }
        
        .huntmlogo{
            width:50px;
            height:50px; 
        }
        
        a{
            text-decoration: none;
        }

        .contanier{
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap:20px;
            margin-top:10%;
           padding: 20px;
        }

        .suggest-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            position: relative;
            left: 30%;
        }
        .suggest-content{
            position: relative;
            left: 1%;
        }
        .suggest-content h1{
            font-size: 50px;
            font-weight: bold;
            color: white;
        }

        .suggest-content p{
            text-align: left;
            display: flex;
            align-items: center;
            font-size: 20px;
            color: white;
            padding:5px 0;
        }

        .suggest-content i{
            font-size: 20px;
            padding-right: 10px;
            color:#0000FF;
        }

        .image-section {
            position: relative;
            width: 100%;
            height: 150px;
            margin-bottom: 15px;
        }

        .image-section img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .image-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .recording-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        .recording-btn:hover {
            background: #0056b3;
        }

        .submit-btn {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: #218838;
        }

        audio {
            display: block;
            margin-top: 10px;
        }
    </style>
    <script>
        let mediaRecorder;
        let audioChunks = [];

        function startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();

                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };
                });
        }

        function stopRecording() {
            mediaRecorder.stop();
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const audioURL = URL.createObjectURL(audioBlob);
                document.getElementById('audioPlayer').src = audioURL;

                const file = new File([audioBlob], "voice_message.wav", { type: 'audio/wav' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('voiceMessageInput').files = dataTransfer.files;
            };
        }
    </script>
</head>
<body>
<header>
        <a href="#"><h1 style="font-size:25px; color:white;"><img src="/Huntm/Image/Huntm-logo.svg" alt="Huntm Logo" class="huntmlogo">Huntm</h1></a>
    </header>
    <div class="contanier">

    <div class="suggest-content">
        <h1>Keep your customers engaged with your business</h1>
        <p><i class="fas fa-chevron-right"></i>Send campaigns to your customers</p>
        <p><i class="fas fa-chevron-right"></i>Track the results</p>
        <p><i class="fas fa-chevron-right"></i>Manage your customers</p>
        <p><i class="fas fa-chevron-right"></i>Get insights</p>
    </div>

    <div class="suggest-form">
    <div class="image-section">
        <img src="/Huntm/Image/Suggestion-image.jpg" alt="Suggestion">
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <p class="success"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <p class="error"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('user/submit_suggestion'); ?>" enctype="multipart/form-data">
    
        <div>
            <select name="application">
                <option value="">Select Application</option>
                <option value="SDMS">SDMS</option>
                <option value="BI Report">BI Report</option>
                <option value="BI Report">Other</option>
            </select>
            <span class="error"><?= form_error('application'); ?></span>
        </div>

        <div>
            <select name="suggestion_type">
                <option value="">Select Suggestion Type</option>
                <option value="Change">Change</option>
                <option value="Suggestion">Suggestion</option>
            </select>
            <span class="error"><?= form_error('suggestion_type'); ?></span>
        </div>

        <div>
            <textarea name="message" placeholder="Enter your message"></textarea>
            <span class="error"><?= form_error('message'); ?></span>
        </div>

        <div>
            <input type="file" name="voice_message">
        </div>

        <button type="submit" class="submit-btn">Save</button>
    </form>

<style>
    .error {
        color: red;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
</style>

    </div>
</div>

</body>
<!-- jQuery Library (Place before closing </body> tag) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(".input-field").on("input change", function () {
            $(this).next(".error").text(""); // Remove error message when user types/selects
        });
    });
</script>
</body>
</html>

</html>
