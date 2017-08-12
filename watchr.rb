require 'colorize'

watch('src/(.*).php')  { |m| code_changed(m[0]) }
watch('tests/(.*).php')  { |m| code_changed(m[0]) }

def code_changed(file)
    run "clear && printf '' && composer run test;"
end

def run(cmd)
    result = `#{cmd}`
    runalert result rescue nil
end

def runalert(message)

    title = /FAILURES/i.match(message.to_s) ? "FAILURES" : "PASS"

    if title == "FAILURES"
        puts message.red
        info = /^Tests(.+)\.$/i.match(message.to_s)
    else
        puts message.green
        info = /^ok\s\((.+)\)$/i.match(message.to_s)
    end
    system %(`osascript -e 'display notification "#{info}" with title "PHP Unit: #{title}"';`)
    system %(`say '#{info}';`)

    # Update documentation if all tests pass successfully
    if title == "PASS"
        document = `#{'composer document'}`
        puts "Documentation Updated".yellow
    end

end