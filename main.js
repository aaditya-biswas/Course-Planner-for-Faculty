const { app, BrowserWindow } = require('electron')
app.commandLine.appendSwitch('ignore-certificate-errors')

const createWindow = () => {
  const win = new BrowserWindow({
    width: 2180,
    height: 1080
  })
  win.loadURL("https://localhost/index.php"); 
  
}

app.whenReady().then(() => {
  createWindow()
  
})