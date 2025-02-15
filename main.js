const { app, BrowserWindow } = require('electron')

const createWindow = () => {
  const win = new BrowserWindow({
    width: 2180,
    height: 1080
  })

  win.loadFile('index.html')
}

app.whenReady().then(() => {
  createWindow()
})