
// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = `/template/vendors/pdfJS/build/pdf.worker.js`;

var currPage = 1; //Pages are 1-based not 0-based
var numPages = 0;
var thePDF = null;

function loadPdf(url) {

    //This is where you start
    pdfjsLib.getDocument(url).promise.then(function (pdf) {

        $('#preview-pdf').html('');
        //Set PDFJS global object (so we can easily access in our page functions
        thePDF = pdf;

        //How many pages it has
        numPages = pdf.numPages;

        //Start with first page
        pdf.getPage(1).then(handlePages);
    })

}



function handlePages(page) {
    //This gives us the page's dimensions at full scale
    var viewport = page.getViewport({ scale: 1.3 });

    //We'll create a canvas for each page to draw it on
    var canvas = document.createElement("canvas");
    canvas.style.display = "block";
    $(canvas).attr('class', 'margin-bottom-5 box-shadow page-pdf');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    //Draw it on the canvas
    page.render({ canvasContext: context, viewport: viewport });
    //Add it to the web page
    $('#preview-pdf').append(canvas)
    //Move to next page
    currPage++;
    if (thePDF !== null && currPage <= numPages) {
        thePDF.getPage(currPage).then(handlePages);
    }
}
