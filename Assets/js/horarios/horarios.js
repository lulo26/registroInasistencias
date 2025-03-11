console.log("hello world");


const btnHorario = document.querySelector("#btnHorario")

btnHorario.addEventListener('click', ()=>{
    document.getElementById("horarioModalLabel").innerHTML =
          "Agregar horario";
      $('#horarioModal').modal('show')
  })

const input = document.getElementById('horarioFile')
const frmHorario = document.getElementById('frmHorario')
//const excelReader = require('excel-reader');

input.addEventListener('change', (e)=>{
  
 const file = e.target.files[0]

 readExcelVertically(file, {
  hasHeader: true,
  sheetIndex: 0
});

console.log(file)
  /*readXlsxFile(file).then((rows) =>{

    rows.forEach(row => {
      row.forEach(cell =>{
        if (cell != null) {
          console.log(cell)
        }
      })
    });
  }) */
})

//////////////////

function readExcelVertically(filePath, options = {}) {
  // Set default options
  const {
    sheetIndex = 0,
    hasHeader = true
  } = options;

  return new Promise((resolve, reject) => {
    // Read the Excel file
    readXlsxFile(filePath, (err, workbook) => {
      if (err) {
        return reject(err);
      }

      try {
        // Get the specified sheet
        const sheet = workbook.sheets[sheetIndex];
        if (!sheet) {
          return reject(new Error(`Sheet at index ${sheetIndex} not found`));
        }

        const rows = sheet.data;
        if (!rows || !rows.length) {
          return resolve({});
        }

        // Find the maximum number of columns
        const maxColumns = rows.reduce((max, row) => Math.max(max, row.length), 0);
        
        // Result object to hold vertical data
        const result = {};

        // Process each column vertically
        for (let col = 0; col < maxColumns; col++) {
          // Get header value if hasHeader is true
          let headerValue;
          
          if (hasHeader && rows[0] && rows[0][col] !== undefined) {
            headerValue = rows[0][col];
          } else {
            headerValue = `Column_${col}`;
          }
          
          // Get all values in this column
          const columnValues = [];
          const startRow = hasHeader ? 1 : 0;
          
          for (let row = startRow; row < rows.length; row++) {
            if (rows[row] && rows[row][col] !== undefined) {
              columnValues.push(rows[row][col]);
            }
          }
          
          // Add column data to result if it has values
          if (columnValues.length > 0) {
            result[headerValue] = columnValues;
          }
        }

        resolve(result);
      } catch (error) {
        reject(error);
      }
    });
  });
}