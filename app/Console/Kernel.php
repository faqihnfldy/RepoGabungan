protected function schedule(Schedule $schedule)
{
    $schedule->command('reminders:send')->daily();
}