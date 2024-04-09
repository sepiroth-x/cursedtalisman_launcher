###########################
# Author: Sepiroth X
# Credits: ChatGPT
# Version: 7.1
# Update: Download missing files via patch + added folder / file name while downloading

import tkinter as tk
import os
import threading
import time
from PIL import Image, ImageTk
from tkinter import messagebox
import requests
import zipfile
import ctypes

INSTALLER_ZIP = "game-client.v.1.1.zip"
PATCHER_ZIP = "patcher.zip"

REQUIRED_FOLDERS = ["audio", "local", "maps", "misc", "model", "model2", "music", "scene", "script", "ui"]

REQUIRED_FILES = ["libiconv2.dll",
                  "client.exe",
                  "game.bat",
                  "local.dll",
                  "fun.dll",
                  "dbghelp.dll",
                  "client_engine.ini",
                  "client_game.ini",
                  "config.ini",
                  "funconfig.ini",
                  "data.evp",
                  "ucfile.evp"
                  ]

UPDATE_URL = "https://cursedtalisman.com/game_updates/version.txt"
CONTENT_UPDATE_SOURCE_URL = "https://cursedtalisman.com/game_updates/"

CLIENT_DOWNLOAD_URL = "https://cursedtalisman.com/game_updates/" + INSTALLER_ZIP
PATCH_URL = "https://cursedtalisman.com/game_updates/" + PATCHER_ZIP

launcher_window_width = 820
launcher_window_height = 580

def launch_game():
    print("Game launched!")
    run_game()
    root.withdraw()  # Hide the launcher window
    # Schedule closing of the window after 45 seconds
    root.after(45000, lambda: close_launcher(root))

def close_window():
    root.destroy()  # Destroy the launcher window

def run_game():
    bat_file_path = "game.bat"
    if os.path.exists(bat_file_path):
        try:
            ctypes.windll.shell32.ShellExecuteW(None, "runas", bat_file_path, None, None, 1)
        except Exception as e:
            messagebox.showerror("Error", str(e))
    else:
        messagebox.showerror("Error", "game.bat file not found.")

def close_launcher(window):
    window.destroy()

def center_window(window):
    window.update_idletasks()
    screen_width = window.winfo_screenwidth()
    screen_height = window.winfo_screenheight()
    window_width = window.winfo_width()
    window_height = window.winfo_height()
    x = (screen_width - window_width) // 2
    y = (screen_height - window_height) // 2
    window.geometry('+{}+{}'.format(x, y))

def move_window(event):
    root.geometry(f'+{event.x_root}+{event.y_root}')

def check_files_and_folders():
    progress_step = 100 / (len(REQUIRED_FOLDERS) + len(REQUIRED_FILES))
    progress_value = 0
    

    if not missing_folders and not missing_files:
        download_update()
        return

    for folder in REQUIRED_FOLDERS:
        if not os.path.exists(folder):
            download_missing_content(folder)
        time.sleep(0.1)  # Simulating folder checking process
        progress_value += progress_step
        update_loading_bar(progress_value)
        root.update_idletasks()

    for file in REQUIRED_FILES:
        if not os.path.exists(file):
            download_missing_content(file)
        time.sleep(0.1)  # Simulating file checking process
        progress_value += progress_step
        update_loading_bar(progress_value)
        root.update_idletasks()

    check_update()

def download_missing_content(item_name):
    try:
        response = requests.get(CONTENT_UPDATE_SOURCE_URL + item_name + ".zip", stream=True)
        total_size = int(response.headers.get('content-length',0))
        with open(item_name + ".zip", "wb") as f:
            bytes_written = 0
            for data in response.iter_content(chunk_size=8192):
                f.write(data)
                bytes_written += len(data)
                progress = (bytes_written / total_size) * 100
                download_loading_bar(progress, item_name)
                root.update_idletasks()
       
        messagebox.showinfo("Content Downloaded", f"{item_name} downloaded successfully.")

        if item_name in REQUIRED_FOLDERS:
            extract_folder(item_name + ".zip")
                       
        elif item_name in REQUIRED_FILES:
            messagebox.showinfo("File Ready", f"{item_name} is ready.")
            if all(file in os.listdir() for file in REQUIRED_FILES):
                launch_button.config(state="normal")
                
        os.remove(item_name + ".zip")  # Delete the downloaded zip file   
    except Exception as e:
        print("Error downloading content:", e)
        messagebox.showinfo("Download Error", f"Downloading {item_name} failed!")
        messagebox.showinfo("Content not available!", f"{item_name} Content might not be in the repository! Contact Admin!")

def extract_folder(folder_name):
    try:
        with zipfile.ZipFile(folder_name, "r") as zip_ref:
            zip_ref.extractall("")  # Extract to the root directory
    except Exception as e:
        print("Error extracting folder:", e)

def update_loading_bar(value):
    loading_bar.delete("progress")
    loading_bar.create_rectangle(0, 0, value * launcher_window_width / 100, 20, fill="white", tag="progress")

def download_loading_bar(value, item_name):
    loading_bar.delete("progress")
    loading_bar.create_rectangle(0, 0, value * launcher_window_width / 100, 20, fill="yellow", tag="progress")
    loading_bar.create_text(5, 10, anchor='w', text=f"Downloading {item_name}...", fill="black")

def check_update():
    try:
        response = requests.get(UPDATE_URL)
        if response.status_code == 200:
            new_version = response.text.strip()
            current_version = get_current_version()
            if new_version != current_version:
                messagebox.showinfo("Update Available! Version:" + new_version, "A new version of the game is available. Click OK to update.")
                loading_bar.delete("progress")
                download_patch()
            else:
                launch_button.config(state="normal")
    except Exception as e:
        print("Error checking for update:", e)
        messagebox.showinfo("Update failed!", "Please temporarily turn off anti-virus and try again.")

def download_patch():
    try:
        response = requests.get(PATCH_URL, stream=True)
        total_size = int(response.headers.get('content-length', 0))

        with open(PATCHER_ZIP, "wb") as f:
            bytes_written = 0
            for data in response.iter_content(chunk_size=8192):
                f.write(data)
                bytes_written += len(data)
                progress = (bytes_written / total_size) * 100
                download_loading_bar(progress, PATCHER_ZIP)
                root.update_idletasks()

        messagebox.showinfo("Patch Downloaded", "Patch downloaded successfully.")

        try:
            with zipfile.ZipFile(PATCHER_ZIP, "r") as zip_ref:
                zip_ref.extractall("")  # Extract to the root directory
        except Exception as e:
            print("Error extracting patch:", e)

        os.remove(PATCHER_ZIP)  # Delete the downloaded zip file

        messagebox.showinfo("Patch Installed", "Game patched successfully!")
        launch_button.config(state="normal")
    except Exception as e:
        print("Error downloading or installing patch:", e)
        messagebox.showinfo("Patch Installation Error", "An error occurred while downloading or installing the patch!")

def get_current_version():
    try:
        with open("version.txt", "r") as file:
            return file.read().strip()
    except FileNotFoundError:
        return "Version file not found"

def create_launcher():
    global root
    launcher_screen_width = launcher_window_width
    launcher_screen_height = launcher_window_height

    root = tk.Tk()
    root.title("Game Launcher")

    root.overrideredirect(True)
    root.geometry("{}x{}".format(launcher_screen_width, launcher_screen_height))
    root.resizable(False, False)

    bg_image = Image.open("misc/src/launcherbanner.png")
    bg_image = bg_image.resize((launcher_screen_width, launcher_screen_height))
    bg_photo = ImageTk.PhotoImage(bg_image)

    background_label = tk.Label(root, image=bg_photo)
    background_label.place(relx=0, rely=0, relwidth=1, relheight=1)

    title_bar = tk.Frame(root, bg='grey', relief='raised', bd=2)
    title_bar.place(relx=0, rely=0, relwidth=1, anchor='n')
    title_bar.bind('<B1-Motion>', move_window)

    close_button = tk.Button(root, text="X", command=lambda: close_launcher(root), bg="red", fg="white", font=("Helvetica", 14), bd=0)
    close_button.place(relx=1.0, rely=0, anchor='ne')

    global loading_bar
    loading_bar = tk.Canvas(root, bg="black", highlightthickness=0)
    loading_bar.place(relx=0.5, rely=1.0, anchor='s', y=-100, relwidth=0.9, height=20)

    threading.Thread(target=check_files_and_folders).start()

    global launch_button
    launch_button = tk.Button(root, text="Launch Game", command=launch_game, bg="#2e2e2e", fg="white", font=("Helvetica", 16), state="disabled")
    launch_button.place(relx=0.5, rely=1.0, anchor='s', y=-50)

    center_window(root)

    root.mainloop()

if __name__ == "__main__":
    create_launcher()
