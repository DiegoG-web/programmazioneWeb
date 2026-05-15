function validateBookForm() {
    var isValid = true;

    const title = $('#title');
    const titleValue = title.val().trim();
    const author = $('#author');
    const authorValue = author.val().trim();
    const year = $('#year');
    const yearValue = year.val().trim();
    const price = $('#price');
    const priceValue = price.val().trim();

    console.log({"title": titleValue, "author": authorValue, "year": yearValue, "price": priceValue});

    //Controllo input titolo
    if(!titleValue) {
        setInvalid(title, 'Title is required.');
        isValid = false;
    }else if(titleValue.length<2){
        setInvalid(title, "Title must contain at least 2 characters");
        isValid = false;
    }else {
        setValid(title);
    }

    //controllo input autore
    if(!authorValue){
        setInvalid(author, 'Author is required.');
        isValid=false;
    }else {
        setValid(author);
    }


    //controllo input anno
    const currentYear = new Date().getFullYear();
    if(!yearValue){
        setInvalid(year, 'Year is required.')
        isValid = false;
    }else if(Number(yearValue) < 500 || Number(yearValue) > currentYear){
        setInvalid(year, `Year must be between 500 and ${currentYear}`)
        // setInvalid(year, 'Year must be between 1000 and' + currentYear);
        isValid=false;
    }else if(!(/^\d{4}$/.test(yearValue))){
        setInvalid(year, 'Year must contain exactly 4 digits.');
        isValid = false;
    }else {
        setValid(year);
    }

    //controllo input prezzo
    if(!priceValue){
        setInvalid(price, 'Price is required');
        isValid=false;
    }else if(priceValue && Number(priceValue) < 0){
        setInvalid(price, 'Price cannot be negative');
        isValid=false;
    }else if(!(/^\d+(\.\d{1,2})?$/.test(priceValue))){
        setInvalid(price, 'Price must be a valid number with up to 2 decimals')
        isValid=false;
    }else if(priceValue && Number(priceValue) > 9999){
        setInvalid(price, 'Price cannot be greater than 9999')
        isValid=false;
    }else{
        setValid(price);
    }

    return isValid;
}
function getOrCreateFeedbackElement(input) {
    let feedback = input.parent().find('.js-invalid-feedback');
    if(!feedback.length) {
        feedback = $('<div></div>').addClass('js-invalid-feedback invalid-feedback');
        input.parent().append(feedback);
    }
    return feedback;

}
function setInvalid($input, $message) {
    $input.addClass('is-invalid');
    $input.removeClass('is-valid');

    const feedback = getOrCreateFeedbackElement($input);
    feedback.text($message);
}

function setValid($input) {
    $input.removeClass('is-invalid');
    $input.addClass('is-valid');

    const feedback = getOrCreateFeedbackElement($input);
    feedback.text('');
}

function submitBookForm(event) {
    console.log(event);

    event.preventDefault();
    var form = $('#bookForm');

    console.log(form);

    var isValid = validateBookForm();
    if(!isValid) {
        var $firstInvalidInput = form.find('.is-invalid').first();
        if($firstInvalidInput.length) {
            $firstInvalidInput.focus();
        }
        return false;
    }

    console.log('Form is valid. Submitting...');
    form[0].submit();
    return true;
}