import "./App.css";

function App() {
  return (
    <div className="flex flex-col min-h-screen bg-gray-900 text-white">
      <header className="py-4 px-8 bg-gray-800 shadow-md">
        <h1 className="text-2xl font-bold">TimeTrack</h1>
      </header>

      <main className="flex-grow p-8">
        <div className="bg-gray-800 p-6 rounded-lg shadow-lg">
          <h2 className="text-xl mb-4">Time Entries</h2>
          <p className="text-gray-400">Time entries will go here.</p>
        </div>
      </main>

      <footer className="py-4 px-8 bg-gray-800 text-center text-sm text-gray-500">
        <p>&copy; 2024 TimeTrack. All rights reserved.</p>
      </footer>
    </div>
  );
}

export default App;
